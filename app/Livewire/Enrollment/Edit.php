<?php

namespace App\Livewire\Enrollment;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Promotion;
use Livewire\Component;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    public Enrollment $enrollment;

    // Champs du formulaire
    #[Rule('required|exists:academic_years,id')]
    public $academic_year_id;

    #[Rule('required|exists:faculties,id')]
    public $faculty_id;

    #[Rule('required|exists:departments,id')]
    public $department_id;

    #[Rule('required|exists:promotions,id')]
    public $promotion_id;

    #[Rule('required|date')]
    public $registration_date;

    // Listes pour les selects
    public $academicYears;
    public $faculties;
    public $departments = [];
    public $promotions = [];

    public function mount(Enrollment $enrollment): void
    {
        $this->enrollment = $enrollment;

        // Pré-remplir les champs avec les valeurs existantes
        $this->academic_year_id = $enrollment->academic_year_id;
        $this->faculty_id = $enrollment->faculty_id;
        $this->department_id = $enrollment->department_id;
        $this->promotion_id = $enrollment->promotion_id;
        $this->registration_date = $enrollment->created_at?->format('Y-m-d');

        // Charger les listes statiques
        $this->academicYears = AcademicYear::orderByDesc('name')->get();
        $this->faculties = Faculty::orderBy('name')->get();

        // Charger les listes dépendantes selon les valeurs existantes
        if ($this->faculty_id) {
            $this->loadDepartments();
        }
        if ($this->department_id) {
            $this->loadPromotions();
        }
    }

    // Réagit au changement de faculté → recharge les départements
    public function updatedFacultyId($value): void
    {
        $this->department_id = null;
        $this->promotion_id = null;
        $this->departments = [];
        $this->promotions = [];

        if ($value) {
            $this->loadDepartments();
        }
    }

    // Réagit au changement de département → recharge les promotions
    public function updatedDepartmentId($value): void
    {
        $this->promotion_id = null;
        $this->promotions = [];

        if ($value) {
            $this->loadPromotions();
        }
    }

    private function loadDepartments(): void
    {
        $this->departments = Department::where('faculty_id', $this->faculty_id)
            ->orderBy('name')
            ->get()
            ->map(fn($d) => ['id' => $d->id, 'name' => $d->name])
            ->toArray();
    }

    private function loadPromotions(): void
    {
        $this->promotions = Promotion::where('department_id', $this->department_id)
            ->orderBy('name')
            ->get()
            ->map(fn($p) => ['id' => $p->id, 'name' => $p->name])
            ->toArray();
    }

    public function save(): void
    {
        $this->validate();

        $this->enrollment->update([
            'academic_year_id' => $this->academic_year_id,
            'faculty_id' => $this->faculty_id,
            'department_id' => $this->department_id,
            'promotion_id' => $this->promotion_id,
            'registration_date' => $this->registration_date,
        ]);

        $this->dispatch('success', message: 'Inscription modifiée avec succès.');
    }

    public function render()
    {
        return view('livewire.enrollment.edit');
    }
}