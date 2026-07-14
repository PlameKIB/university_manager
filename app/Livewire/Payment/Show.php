<?php

namespace App\Livewire\Payment;

use App\Models\Payment;
use Livewire\Component;

class Show extends Component
{
     public Payment $payment;
 
    public function mount(Payment $payment)
    {
        $this->payment = $payment->load([
            'enrollment.user',
            'enrollment.faculty',
            'enrollment.promotion',
            'enrollment.academicYear',
            'items.fee',
        ]);
    }
    public function render()
    {
        return view('livewire.payment.show');
    }
}
