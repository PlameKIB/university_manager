<?php

namespace Database\Seeders;

use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Fee;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\PaymentItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class GradePaymentSeeder extends Seeder
{
    public function run(): void
    {
        $assignments = CourseAssignment::all();

        foreach ($assignments as $assignment) {
            $studentIds = Enrollment::where('promotion_id', $assignment->promotion_id)
                ->where('academic_year_id', $assignment->academic_year_id)
                ->pluck('user_id');

            foreach ($studentIds as $studentId) {
                $seed = ($assignment->id + $studentId) % 8;
                $tp = round($assignment->bareme_tp * (0.55 + $seed * 0.05), 2);
                $interro = round($assignment->bareme_interro * (0.55 + ($seed + 1) * 0.05), 2);
                $examen = round($assignment->bareme_examen * (0.55 + ($seed + 2) * 0.05), 2);

                Grade::updateOrCreate(
                    [
                        'course_assignment_id' => $assignment->id,
                        'user_id' => $studentId,
                    ],
                    [
                        'tp' => min($assignment->bareme_tp, $tp),
                        'interro' => min($assignment->bareme_interro, $interro),
                        'examen' => min($assignment->bareme_examen, $examen),
                    ]
                );
            }
        }

        $feeTemplates = [
            'Inscription' => 150000,
            'Minerval' => 450000,
            'Frais académiques' => 120000,
        ];

        $promotionYears = Enrollment::select('promotion_id', 'academic_year_id')
            ->distinct()
            ->get();

        foreach ($promotionYears as $row) {
            foreach ($feeTemplates as $name => $amount) {
                Fee::firstOrCreate(
                    [
                        'promotion_id' => $row->promotion_id,
                        'academic_year_id' => $row->academic_year_id,
                        'name' => $name,
                    ],
                    [
                        'amount' => $amount,
                    ]
                );
            }
        }

        $enrollments = Enrollment::with('academicYear')->get();

        foreach ($enrollments as $enrollment) {
            $fees = Fee::where('promotion_id', $enrollment->promotion_id)
                ->where('academic_year_id', $enrollment->academic_year_id)
                ->get();

            if ($fees->isEmpty()) {
                continue;
            }

            $receiptNumber = sprintf('REC-%s-%s', $enrollment->id, $enrollment->academic_year_id);
            $totalAmount = $fees->sum('amount');
            $paymentDate = Carbon::parse($enrollment->registration_date)->addDays(7)->toDateString();

            $payment = Payment::firstOrCreate(
                ['receipt_number' => $receiptNumber],
                [
                    'enrollment_id' => $enrollment->id,
                    'payment_date' => $paymentDate,
                    'total_amount' => $totalAmount,
                    'note' => "Paiement pour l'année {$enrollment->academicYear->name}",
                ]
            );

            foreach ($fees as $fee) {
                PaymentItem::firstOrCreate(
                    [
                        'payment_id' => $payment->id,
                        'fee_id' => $fee->id,
                    ],
                    [
                        'amount' => $fee->amount,
                    ]
                );
            }
        }
    }
}
