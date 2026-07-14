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
        $students = User::query()

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
            'totalStudents' => User::role('student')->count(),

            'maleStudents' => User::role('student')->where('genre', 'M')->count(),

        ]);
    }
}