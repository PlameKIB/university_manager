<?php

namespace App\Livewire\Student;

use App\Models\User;
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $student = User::findOrFail($id);

        $student->delete();

        session()->flash(
            'success',
            'Étudiant supprimé avec succès.'
        );
    }

    public function render()
    {
        $query = User::query()
            ->role('student')
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('users.name', 'like', '%' . $this->search . '%')
                        ->orWhere('users.matricule', 'like', '%' . $this->search . '%')
                        ->orWhere('users.email', 'like', '%' . $this->search . '%')
                        ->orWhere('users.telephone', 'like', '%' . $this->search . '%');
                });
            });

        $students = $query->latest('users.created_at')->paginate(10);
        return view('livewire.student.index', [
            'students' => $students,

            // STATS
            'totalStudents' => User::role('student')->count(),
            'maleStudents' => User::role('student')->where('genre', 'M')->count(),
            'femaleStudents' => User::role('student')->where('genre', 'F')->count(),
        ]);
    }
}