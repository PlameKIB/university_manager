<?php

namespace App\Livewire\Enrollment;

use App\Models;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Promotion;
use App\Models\Student;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $step = 1;

    public $search = '';
    public $searchResults = [];       // Liste des résultats de recherche
    public $existingStudent = null;
    public $isNewStudent = false;

    // =====================
    // ETUDIANT
    // =====================
    public $student_id;
    public $matricule;
    public $nom;
    public $postnom;
    public $prenom;
    public $genre;
    public $telephone;
    public $email;
    public $date_naissance;
    public $adresse;

    // INSCRIPTION
    public $academic_year_id;
    public $faculty_id;
    public $department_id;
    public $promotion_id;
    public $registration_date;

    // DYNAMIQUE
    public $departments = [];
    public $promotions = [];

    // =====================
    // RECHERCHE ETUDIANT — retourne une liste
    // =====================
    public function updatedSearch($value)
    {
        $this->existingStudent = null;
        $this->isNewStudent = false;
        $this->searchResults = [];

        if (blank($this->search)) {
            return;
        }

        $results = Student::where('matricule', 'like', '%' . $this->search . '%')
            ->orWhere('telephone', 'like', '%' . $this->search . '%')
            ->orWhere('nom', 'like', '%' . $this->search . '%')
            ->orWhere('postnom', 'like', '%' . $this->search . '%')
            ->limit(10)
            ->get();

        if ($results->isEmpty()) {
            $this->isNewStudent = true;
        } else {
            // Convertir en tableau pour éviter les problèmes de sérialisation Livewire
            $this->searchResults = $results->map(fn($s) => [
                'id' => $s->id,
                'matricule' => $s->matricule,
                'nom' => $s->nom,
                'postnom' => $s->postnom,
                'prenom' => $s->prenom,
                'telephone' => $s->telephone,
                'email' => $s->email,
            ])->toArray();
        }
    }
    public function setIsNewStudent()
    {
        $this->isNewStudent = true;
        $this->searchResults = [];
        $this->existingStudent = null;

    }
    // =====================
    // SÉLECTION D'UN ÉTUDIANT DANS LA LISTE
    // =====================
    public function selectStudent(int $studentId)
    {
        $student = Student::findOrFail($studentId);

        $this->existingStudent = $student;
        $this->student_id = $student->id;
        $this->isNewStudent = false;
        $this->searchResults = [];   // on ferme la liste
    }

    // =====================
    // NAVIGATION
    // =====================
    public function nextStep()
    {
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    // =====================
    // DYNAMIQUE faculté → département → promotion
    // =====================
    public function updatedFacultyId($value)
    {
        $this->departments = Department::where('faculty_id', $value)->orderBy('name')->get()->toArray();
        $this->department_id = null;
        $this->promotion_id = null;
        $this->promotions = [];
    }

    public function updatedDepartmentId($value)
    {
        $this->promotions = Promotion::where('department_id', $value)->orderBy('name')->get()->toArray();
        $this->promotion_id = null;
    }

    // =====================
    // SAVE
    // =====================
    public function save()
    {
        $this->validate([
            'academic_year_id' => 'required',
            'faculty_id' => 'required',
            'department_id' => 'required',
            'promotion_id' => 'required',
            'registration_date' => 'required|date',
        ]);

        DB::transaction(function () {
            if ($this->isNewStudent) {
                $student = Student::create([
                    'matricule' => $this->matricule,
                    'nom' => $this->nom,
                    'postnom' => $this->postnom,
                    'prenom' => $this->prenom,
                    'genre' => $this->genre,
                    'telephone' => $this->telephone,
                    'email' => $this->email,
                    'date_naissance' => $this->date_naissance,
                    'adresse' => $this->adresse,
                ]);
                $this->student_id = $student->id;
            }

            Enrollment::create([
                'student_id' => $this->student_id,
                'academic_year_id' => $this->academic_year_id,
                'faculty_id' => $this->faculty_id,
                'department_id' => $this->department_id,
                'promotion_id' => $this->promotion_id,
                'registration_date' => $this->registration_date,
                'status' => 'active',
            ]);
        });

        $this->reset();
        $this->step = 1;

        $this->dispatch('success', message: 'Inscription enregistrée avec succès');
    }

    public function render()
    {
        return view('livewire.enrollment.create', [
            'academicYears' => AcademicYear::all(),
            'faculties' => Faculty::orderBy('name')->get(),
            'enrollments' => Enrollment::with([
                'student',
                'academicYear',
                'faculty',
                'department',
                'promotion'
            ])->latest()->get(),
        ]);
    }
}
