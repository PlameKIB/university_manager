<?php

namespace App\Livewire\Payment;

use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\Fee;
use Livewire\Component;
use Livewire\WithPagination;

class StudentBalances extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $academic_year_id = '';
    public $onlyUnpaid = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'academic_year_id' => ['except' => ''],
    ];

    public function mount()
    {
        $this->academic_year_id = AcademicYear::where('is_active', true)->value('id') ?? '';
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingAcademicYearId()
    {
        $this->resetPage();
    }

    public function updatingOnlyUnpaid()
    {
        $this->resetPage();
    }

    public function render()
    {
        $enrollments = Enrollment::query()
            ->with(['user', 'faculty', 'promotion', 'academicYear', 'payments'])
            ->when($this->academic_year_id, fn($q) => $q->where('academic_year_id', $this->academic_year_id))
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('matricule', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('registration_date')
            ->paginate(15);

        // Calcule le solde de chaque étudiant : total des frais dus (promotion + année)
        // moins le total déjà payé sur cette inscription.
        $enrollments->getCollection()->transform(function ($enrollment) {
            $totalFees = (float) Fee::where('promotion_id', $enrollment->promotion_id)
                ->where('academic_year_id', $enrollment->academic_year_id)
                ->sum('amount');

            $totalPaid = (float) $enrollment->payments->sum('total_amount');

            $enrollment->total_fees = $totalFees;
            $enrollment->total_paid = $totalPaid;
            $enrollment->balance = $totalFees - $totalPaid;

            return $enrollment;
        });

        if ($this->onlyUnpaid) {
            $enrollments->setCollection(
                $enrollments->getCollection()->filter(fn($e) => $e->balance > 0)->values()
            );
        }

        return view('livewire.payment.student-balances', [
            'enrollments' => $enrollments,
            'academicYears' => AcademicYear::orderByDesc('name')->get(),
        ]);
    }
}