<?php

namespace App\Livewire\Payment;

use App\Models\AcademicYear;
use App\Models\Payment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $payment_date = '';
    public $academic_year_id = '';

    public function delete($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();
        $this->dispatch('success', message: 'Paiement supprimé avec succès.');
    }

    public function render()
    {
        $payments = Payment::query()
            ->with(['enrollment.user', 'enrollment.faculty', 'enrollment.promotion', 'items.fee'])
            ->when($this->search, function ($q) {
                $q->where('receipt_number', 'like', "%{$this->search}%")
                    ->orWhereHas('enrollment.user', function ($q) {
                        $q->where('nom', 'like', "%{$this->search}%")
                            ->orWhere('prenom', 'like', "%{$this->search}%")
                            ->orWhere('matricule', 'like', "%{$this->search}%");
                    });
            })
            ->when($this->payment_date, fn($q) => $q->whereDate('payment_date', $this->payment_date))
            ->when($this->academic_year_id, fn($q) => $q->whereHas('enrollment', fn($q) => $q->where('academic_year_id', $this->academic_year_id)))
            ->latest('payment_date')
            ->paginate(10);
        return view('livewire.payment.index', [
            'payments' => $payments,
            'totalAmount' => Payment::sum('total_amount'),
            'todayCount' => Payment::whereDate('payment_date', today())->count(),
            'academicYears' => AcademicYear::orderByDesc('name')->get(),
            'currentYear' => AcademicYear::where('is_active', true)->first(),
        ]);
    }
}
