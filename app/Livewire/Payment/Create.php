<?php

namespace App\Livewire\Payment;

use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    public $studentSearch = '';
    public $selectedEnrollment = null;

    public $receipt_number = '';
    public $payment_date;
    public $note = '';

    public $items = [
        ['fee_id' => '', 'amount' => ''],
    ];

    public function mount()
    {
        $this->payment_date = now()->format('Y-m-d');
        $this->receipt_number = $this->generateReceiptNumber();
    }

    public function getEnrollmentResultsProperty()
    {
        if (strlen($this->studentSearch) < 2) {
            return collect();
        }

        return Enrollment::query()
            ->with(['student', 'faculty', 'promotion', 'academicYear'])
            ->whereHas('student', function ($q) {
                $q->where('nom', 'like', "%{$this->studentSearch}%")
                    ->orWhere('prenom', 'like', "%{$this->studentSearch}%")
                    ->orWhere('matricule', 'like', "%{$this->studentSearch}%");
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
        $this->selectedEnrollment = Enrollment::with(['student', 'faculty', 'promotion', 'academicYear'])
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
        $this->items[] = ['fee_id' => '', 'amount' => ''];
    }

    public function removeItem($index)
    {
        if (count($this->items) === 1) {
            return;
        }

        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $key)
    {
        // Auto-remplit le montant quand un frais est sélectionné
        [$index, $field] = explode('.', $key);

        if ($field === 'fee_id' && $value) {
            $fee = Fee::find($value);
            if ($fee) {
                $this->items[$index]['amount'] = $fee->amount;
            }
        }
    }

    protected function generateReceiptNumber()
    {
        $year = now()->format('Y');
        $last = Payment::whereYear('created_at', $year)->count() + 1;

        return 'REC-' . $year . '-' . str_pad($last, 5, '0', STR_PAD_LEFT);
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
        $payment = null; // Initialize the payment variable
        DB::transaction(function () {
            $payment = Payment::create([
                'enrollment_id' => $this->selectedEnrollment->id,
                'receipt_number' => $this->receipt_number,
                'payment_date' => $this->payment_date,
                'total_amount' => $this->totalAmount,
                'note' => $this->note,
            ]);

            foreach ($this->items as $item) {
                PaymentItem::create([
                    'payment_id' => $payment->id,
                    'fee_id' => $item['fee_id'],
                    'amount' => $item['amount'],
                ]);
            }
        });

        $this->dispatch('success', message: 'Paiement enregistré avec succès.');
        $this->redirect(back()); 
    }
    public function render()
    {
        return view('livewire.payment.create', [
            'totalAmount' => $this->getTotalAmountProperty(),
            'enrollmentResults' => $this->getEnrollmentResultsProperty(),
            'fees' => Fee::orderBy('name')->get(),
        ]);
    }
}
