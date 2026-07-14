<?php

namespace App\Livewire\Enrollment;

use Livewire\Component;

use App\Models\AcademicYear;
use App\Models\Enrollment;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // =========================
    // FILTERS
    // =========================
    public $search = '';

    public $academic_year_id = '';

    // =========================
    // QUERY STRING
    // =========================
    protected $queryString = [
        'search' => ['except' => ''],
        'academic_year_id' => ['except' => ''],
    ];

    // =========================
    // RESET PAGINATION
    // =========================
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAcademicYearId()
    {
        $this->resetPage();
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $inscription = Enrollment::findOrFail($id);

        $inscription->delete();

        session()->flash(
            'success',
            'Inscription supprimée avec succès.'
        );
    }
    public function render()
    {
        $query = Enrollment::query()
            ->with([
                'user',
                'faculty',
                'promotion',
                'academicYear',
            ])

            ->when($this->search, function ($q) {

                $q->whereHas('user', function ($user) {

                    $user->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('matricule', 'like', '%' . $this->search . '%')
                        ->orWhere('telephone', 'like', '%' . $this->search . '%');
                });
            })

            ->when($this->academic_year_id, function ($q) {

                $q->where('academic_year_id', $this->academic_year_id);
            })

            ->latest();

        $inscriptions = $query->paginate(10);

        return view('livewire.enrollment.index', [
            'inscriptions' => $inscriptions,

            'academicYears' => AcademicYear::latest()->get(),

            // =========================
            // STATS
            // =========================
            'activeCount' => Enrollment::count(),

            'filiereCount' => Enrollment::distinct('promotion_id')->count(),

            'currentYear' => AcademicYear::where('is_active', true)->first(),
        ]);
    }
}