<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\DocumentService;

class Receipt extends Controller
{
    public function __invoke(Payment $payment, DocumentService $documents)
    {
        $payment->load([
            'enrollment.user',
            'enrollment.faculty',
            'enrollment.promotion',
            'enrollment.academicYear',
            'items.fee',
        ]);

        $meta = [
            'etudiant' => $payment->enrollment->user->name ?? '--',
            'matricule' => $payment->enrollment->user->matricule ?? '--',
            'recu_numero' => $payment->receipt_number,
            'montant' => number_format($payment->total_amount, 2, ',', ' ') . ' $',
            'date_paiement' => optional($payment->payment_date)->toDateString(),
        ];

        return $documents->generate(
            type: 'recu',
            view: 'pdf.receipt',
            viewData: [
                'payment' => $payment,
                'enrollment' => $payment->enrollment,
            ],
            meta: $meta,
            documentable: $payment,
        );
    }
}
