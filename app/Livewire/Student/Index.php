<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // =========================
    // FILTERS
    // =========================
    public $search = '';

    // =========================
    // QUERY STRING
    // =========================
    protected $queryString = [
        'search' => ['except' => ''],
    ];

    // =========================
    // RESET PAGINATION
    // =========================
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $student = Student::findOrFail($id);

        $student->delete();

        session()->flash(
            'success',
            'Étudiant supprimé avec succès.'
        );
    }

    // =========================
    // RENDER
    // =========================
    public function render()
    {
        $students = Student::query()

            ->when($this->search, function ($query) {

                $query->where('nom', 'like', '%' . $this->search . '%')
                    ->orWhere('postnom', 'like', '%' . $this->search . '%')
                    ->orWhere('prenom', 'like', '%' . $this->search . '%')
                    ->orWhere('matricule', 'like', '%' . $this->search . '%')
                    ->orWhere('telephone', 'like', '%' . $this->search . '%');
            })

            ->latest()
            ->paginate(10);

        return view('livewire.student.index', [

            'students' => $students,

            // STATS
            'totalStudents' => Student::count(),

            'maleStudents' => Student::where('genre', 'M')->count(),

            'femaleStudents' => Student::where('genre', 'F')->count(),

        ]);
    }
}