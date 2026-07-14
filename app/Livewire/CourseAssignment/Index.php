<?php

namespace App\Livewire\CourseAssignment;

use App\Models\AcademicYear;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\Promotion;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Index extends Component
{
    #[Rule('required|exists:courses,id', as: 'Cours')]
    public $course_id;

    #[Rule('required|exists:promotions,id', as: 'Promotion')]
    public $promotion_id;

    #[Rule('required|exists:users,id', as: 'Enseignant')]
    public $user_id;

    #[Rule('required|exists:academic_years,id', as: 'Année académique')]
    public $academic_year_id;

    #[Rule('required|integer|min:1|max:60', as: 'Crédit')]
    public $credit;

    #[Rule('required|numeric|min:0', as: 'Barème TP')]
    public $bareme_tp = 10;

    #[Rule('required|numeric|min:0', as: 'Barème Interro')]
    public $bareme_interro = 20;

    #[Rule('required|numeric|min:0', as: 'Barème Examen')]
    public $bareme_examen = 50;

    public $assignment_id;

    public $isEditing = false;

    public function save()
    {
        $this->validate();

        CourseAssignment::create([
            'course_id' => $this->course_id,
            'promotion_id' => $this->promotion_id,
            'user_id' => $this->user_id,
            'academic_year_id' => $this->academic_year_id,
            'credit' => $this->credit,
            'bareme_tp' => $this->bareme_tp,
            'bareme_interro' => $this->bareme_interro,
            'bareme_examen' => $this->bareme_examen,
        ]);

        $this->reset();
        $this->bareme_tp = 10;
        $this->bareme_interro = 20;
        $this->bareme_examen = 50;

        $this->dispatch('success', message: 'Attribution enregistrée avec succès');
    }

    public function edit($id)
    {
        $assignment = CourseAssignment::findOrFail($id);

        $this->assignment_id = $assignment->id;
        $this->course_id = $assignment->course_id;
        $this->promotion_id = $assignment->promotion_id;
        $this->user_id = $assignment->user_id;
        $this->academic_year_id = $assignment->academic_year_id;
        $this->credit = $assignment->credit;
        $this->bareme_tp = $assignment->bareme_tp;
        $this->bareme_interro = $assignment->bareme_interro;
        $this->bareme_examen = $assignment->bareme_examen;

        $this->isEditing = true;
    }

    public function update()
    {
        $this->validate();

        CourseAssignment::findOrFail($this->assignment_id)->update([
            'course_id' => $this->course_id,
            'promotion_id' => $this->promotion_id,
            'user_id' => $this->user_id,
            'academic_year_id' => $this->academic_year_id,
            'credit' => $this->credit,
            'bareme_tp' => $this->bareme_tp,
            'bareme_interro' => $this->bareme_interro,
            'bareme_examen' => $this->bareme_examen,
        ]);

        $this->reset();
        $this->isEditing = false;

        $this->dispatch('success', message: 'Attribution modifiée avec succès');
    }

    public function delete($id)
    {
        CourseAssignment::findOrFail($id)->delete();

        $this->dispatch('success', message: 'Attribution supprimée');
    }

    public function render()
    {
        // dd(User:);
        return view('livewire.course-assignment.index', [
            'assignments' => CourseAssignment::with(['course', 'promotion', 'teacher', 'academicYear'])
                ->latest()
                ->get(),
            'courses' => Course::orderBy('intitule')->get(),
            'promotions' => Promotion::with('department')->orderBy('name')->get(),
            'teachers' => User::role('enseignant')->orderBy('name')->get(),
            'academicYears' => AcademicYear::latest()->get(),
        ]);
    }
}