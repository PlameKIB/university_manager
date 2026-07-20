<?php

namespace App\Livewire\Enrollment;

use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $step = 1;

    public $search = '';
    public $searchResults = [];
    public $existingStudent = null;
    public $isNewStudent = false;

    // =====================
    // ETUDIANT
    // =====================
    public $student_id;
    public $matricule;
    public $genre;
    public $telephone;
    public $name;
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

    public function updatedSearch($value)
    {
        $this->existingStudent = null;
        $this->isNewStudent = false;
        $this->searchResults = [];

        if (blank($this->search)) {
            return;
        }

        $results = User::role('student')
            ->where(function ($query) {
                $query->where('matricule', 'like', '%' . $this->search . '%')
                    ->orWhere('telephone', 'like', '%' . $this->search . '%')
                    ->orWhere('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->limit(10)
            ->get();

        if ($results->isEmpty()) {
            $this->isNewStudent = true;
        } else {
            $this->searchResults = $results->map(fn($s) => [
                'id' => $s->id,
                'matricule' => $s->matricule,
                'name' => $s->name,
                'genre' => $s->genre,
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

    public function selectStudent(int $studentId)
    {
        $student = User::findOrFail($studentId);

        $this->existingStudent = $student;
        $this->student_id = $student->id;
        $this->isNewStudent = false;
        $this->searchResults = [];
    }

    public function nextStep()
    {
        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function resetExistingStudent()
    {
        $this->existingStudent = null;
    }

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

    public function save()
    {
        $this->validate([
            'academic_year_id' => 'required|exists:academic_years,id',
            'faculty_id' => 'required|exists:faculties,id',
            'department_id' => 'required|exists:departments,id',
            'promotion_id' => 'required|exists:promotions,id',
            'registration_date' => 'required|date',
        ]);

        if ($this->isNewStudent) {
            $this->validate([
                'matricule' => 'required|string|max:50|unique:users,matricule',
                'name' => 'required|string|max:255',
                'genre' => 'required|string|max:2',
                'telephone' => 'required|string|max:50|unique:users,telephone',
                'email' => 'required|email|max:255|unique:users,email',
                'date_naissance' => 'required|date',
                'adresse' => 'required|string|max:255',
            ]);
        } else {
            $this->validate([
                'student_id' => 'required|exists:users,id',
            ]);
        }

        DB::transaction(function () {
            if ($this->isNewStudent) {
                $student = User::create([
                    'matricule' => $this->matricule,
                    'name' => $this->name,
                    'genre' => $this->genre,
                    'telephone' => $this->telephone,
                    'email' => $this->email,
                    'date_naissance' => $this->date_naissance,
                    'adresse' => $this->adresse,
                ]);
                $this->student_id = $student->id;
            } else {
                $student = User::findOrFail($this->student_id);
            }

            Enrollment::create([
                'user_id' => $this->student_id,
                'academic_year_id' => $this->academic_year_id,
                'faculty_id' => $this->faculty_id,
                'department_id' => $this->department_id,
                'promotion_id' => $this->promotion_id,
                'registration_date' => $this->registration_date,
                'status' => 'active',
            ]);

            $student->assignRole('student');
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
                'user',
                'academicYear',
                'faculty',
                'department',
                'promotion'
            ])->latest()->get(),
        ]);
    }
}