<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class Receipt extends Controller
{
    public function __invoke(Payment $payment)
    {
        $payment->load([
            'enrollment.student',
            'enrollment.faculty',
            'enrollment.promotion',
            'enrollment.academicYear',
            'items.fee',
        ]);

        return view('payment.receipt', compact('payment'));
    }
}
