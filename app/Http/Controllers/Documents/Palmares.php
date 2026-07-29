<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Promotion;
use App\Services\DocumentService;

class Palmares extends Controller
{
    public function __invoke(Promotion $promotion, ?AcademicYear $academicYear, DocumentService $documents)
    {
        $academicYear = $academicYear ?? AcademicYear::where('is_active', true)->first();

        if (!$academicYear) {
            return response()->view('documents.blocked', [
                'message' => "Aucune année académique active n'a été trouvée. Veuillez en activer une avant de générer le palmarès.",
            ]);
        }

        $promotion->load('department.faculty');

        $enrollments = Enrollment::with('user')
            ->where('promotion_id', $promotion->id)
            ->where('academic_year_id', $academicYear->id)
            ->where('status', 'active')
            ->get();

        $assignments = CourseAssignment::where('promotion_id', $promotion->id)
            ->where('academic_year_id', $academicYear->id)
            ->get();

        $assignmentIds = $assignments->pluck('id');

        $ranking = $enrollments->map(function ($enrollment) use ($assignments, $assignmentIds) {
            $grades = Grade::whereIn('course_assignment_id', $assignmentIds)
                ->where('user_id', $enrollment->user_id)
                ->get()
                ->keyBy('course_assignment_id');

            $totalCredits = 0;
            $totalPoints = 0;

            foreach ($assignments as $assignment) {
                $grade = $grades->get($assignment->id);
                $coteFinale = $grade?->cote_finale ?? 0;
                $baremeTotal = $assignment->bareme_total ?: 1;
                $pourcentage = ($coteFinale / $baremeTotal) * 100;

                $totalCredits += $assignment->credit;
                $totalPoints += ($pourcentage / 100) * $assignment->credit;
            }

            $pourcentageGeneral = $totalCredits > 0 ? ($totalPoints / $totalCredits) * 100 : 0;

            $mention = match (true) {
                $pourcentageGeneral >= 80 => 'Grande Distinction',
                $pourcentageGeneral >= 70 => 'Distinction',
                $pourcentageGeneral >= 50 => 'Satisfaction',
                default => 'Échec',
            };

            return [
                'user' => $enrollment->user,
                'pourcentage' => round($pourcentageGeneral, 2),
                'moyenne' => round($pourcentageGeneral * 20 / 100, 2),
                'mention' => $mention,
                'decision' => $pourcentageGeneral >= 50 ? 'ADMIS(E)' : 'AJOURNÉ(E)',
            ];
        })
            ->sortByDesc('pourcentage')
            ->values()
            ->map(function ($row, $index) {
                $row['rang'] = $index + 1;
                return $row;
            });

        $meta = [
            'promotion' => $promotion->name,
            'annee_academique' => $academicYear->name,
            'nombre_etudiants' => $ranking->count(),
        ];

        return $documents->generate(
            type: 'palmares',
            view: 'pdf.palmares',
            viewData: [
                'promotion' => $promotion,
                'academicYear' => $academicYear,
                'ranking' => $ranking,
            ],
            meta: $meta,
            documentable: $promotion,
        );
    }
}
