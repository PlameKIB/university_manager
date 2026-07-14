<?php

namespace App\Livewire\Payment;

use App\Models;
use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Support\Facades\DB;
// use App\Models\PaymentItem;
use Livewire\Component;

class Edit extends Component
{
    public Payment $payment;
    public $studentSearch = '';
    public $selectedEnrollment = null;

    public $receipt_number = '';
    public $payment_date;
    public $note = '';

    // items existants : ['id' => ?, 'fee_id' => ..., 'amount' => ...]
    public $items = [];

    // ids des items supprimés pendant l'édition (à effacer en base au save)
    public $deletedItemIds = [];

    public function mount(Payment $payment)
    {
        $payment->load(['enrollment.user', 'enrollment.faculty', 'enrollment.promotion', 'enrollment.academicYear', 'items']);

        $this->payment = $payment;
        $this->selectedEnrollment = $payment->enrollment;

        $this->receipt_number = $payment->receipt_number;
        $this->payment_date = optional($payment->payment_date)->format('Y-m-d') ?? $payment->payment_date;
        $this->note = $payment->note;

        $this->items = $payment->items->map(function ($item) {
            return [
                'id' => $item->id,
                'fee_id' => $item->fee_id,
                'amount' => $item->amount,
            ];
        })->toArray();

        if (empty($this->items)) {
            $this->items[] = ['id' => null, 'fee_id' => '', 'amount' => ''];
        }
    }

    public function getEnrollmentResultsProperty()
    {
        if (strlen($this->studentSearch) < 2) {
            return collect();
        }

        return Enrollment::query()
            ->with(['user', 'faculty', 'promotion', 'academicYear'])
            ->whereHas('user', function ($q) {
                $q->where('name', 'like', "%{$this->studentSearch}%")
                    ->orWhere('matricule', 'like', "%{$this->studentSearch}%")
                    ->orWhere('gmail', 'like', "%{$this->studentSearch}%");

            })
            ->latest()
            ->limit(8)
            ->get();
    }

    public function getFeesProperty()
    {
        return Fee::orderBy('name')->get();
    }

    public function getTotalAmountProperty()
    {
        return collect($this->items)->sum(fn($item) => (float) ($item['amount'] ?? 0));
    }

    public function selectEnrollment($enrollmentId)
    {
        $this->selectedEnrollment = Enrollment::with(['user', 'faculty', 'promotion', 'academicYear'])
            ->findOrFail($enrollmentId);

        $this->studentSearch = '';
    }

    public function clearEnrollment()
    {
        $this->selectedEnrollment = null;
        $this->studentSearch = '';
    }

    public function addItem()
    {
        $this->items[] = ['id' => null, 'fee_id' => '', 'amount' => ''];
    }

    public function removeItem($index)
    {
        if (count($this->items) === 1) {
            return;
        }

        // si l'item existait déjà en base, on le marque pour suppression
        if (!empty($this->items[$index]['id'])) {
            $this->deletedItemIds[] = $this->items[$index]['id'];
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        [$index, $field] = explode('.', $key);

        if ($field === 'fee_id' && $value) {
            $fee = Fee::find($value);
            if ($fee) {
                $this->items[$index]['amount'] = $fee->amount;
            }
        }
    }

    protected function rules()
    {
        return [
            'payment_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.fee_id' => 'required|exists:fees,id',
            'items.*.amount' => 'required|numeric|min:0.01',
        ];
    }

    protected function validationAttributes()
    {
        return [
            'items.*.fee_id' => 'frais',
            'items.*.amount' => 'montant',
        ];
    }

    public function save()
    {
        if (!$this->selectedEnrollment) {
            $this->dispatch('error', message: 'Veuillez sélectionner un étudiant.');
            return;
        }

        $this->validate();

        DB::transaction(function () {

            $this->payment->update([
                'enrollment_id' => $this->selectedEnrollment->id,
                'payment_date' => $this->payment_date,
                'total_amount' => $this->totalAmount,
                'note' => $this->note,
            ]);

            // supprimer les items retirés par l'utilisateur
            if (!empty($this->deletedItemIds)) {
                PaymentItem::whereIn('id', $this->deletedItemIds)->delete();
            }

            // mettre à jour ou créer les items restants
            foreach ($this->items as $item) {
                if (!empty($item['id'])) {
                    PaymentItem::where('id', $item['id'])->update([
                        'fee_id' => $item['fee_id'],
                        'amount' => $item['amount'],
                    ]);
                } else {
                    PaymentItem::create([
                        'payment_id' => $this->payment->id,
                        'fee_id' => $item['fee_id'],
                        'amount' => $item['amount'],
                    ]);
                }
            }
        });

        $this->dispatch('success', message: 'Paiement mis à jour avec succès.');

        $this->redirect(route('payment.index'), navigate: true);
    }

    public function render()
    {

        return view('livewire.payment.edit',[
            'totalAmount' => $this->getTotalAmountProperty(),
            'enrollmentResults' => $this->getEnrollmentResultsProperty(),
            'fees' => Fee::orderBy('name')->get(),
        ]);
    }
}
