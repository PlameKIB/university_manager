<?php

namespace App\Http\Controllers\Releve;

use App\Http\Controllers\Controller;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Services\DocumentService;

class Show extends Controller
{
    public function __invoke(Enrollment $enrollment, DocumentService $documents)
    {
        $enrollment->load(['user', 'faculty', 'department', 'promotion', 'academicYear']);

        $assignments = CourseAssignment::with('course')
            ->where('promotion_id', $enrollment->promotion_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->get();

        $grades = Grade::whereIn('course_assignment_id', $assignments->pluck('id'))
            ->where('user_id', $enrollment->user_id)
            ->get()
            ->keyBy('course_assignment_id');

        $lines = $assignments->map(function ($assignment) use ($grades) {
            $grade = $grades->get($assignment->id);

            $coteFinale = $grade?->cote_finale ?? 0;
            $baremeTotal = $assignment->bareme_total ?: 1;
            $pourcentage = ($coteFinale / $baremeTotal) * 100;
            $pointsPonderes = ($pourcentage / 100) * $assignment->credit;

            return (object) [
                'course' => $assignment->course,
                'credit' => $assignment->credit,
                'tp' => $grade?->tp,
                'interro' => $grade?->interro,
                'examen' => $grade?->examen,
                'cote_finale' => $coteFinale,
                'bareme_total' => $assignment->bareme_total,
                'pourcentage' => round($pourcentage, 2),
                'points_ponderes' => $pointsPonderes,
                'is_graded' => (bool) $grade,
            ];
        });

        $totalCredits = $lines->sum('credit');
        $totalPoints = $lines->sum('points_ponderes');
        $pourcentageGeneral = $totalCredits > 0 ? ($totalPoints / $totalCredits) * 100 : 0;
        $moyenneSur20 = $pourcentageGeneral * 20 / 100;

        $mention = match (true) {
            $pourcentageGeneral >= 80 => 'Grande Distinction',
            $pourcentageGeneral >= 70 => 'Distinction',
            $pourcentageGeneral >= 50 => 'Satisfaction',
            default => 'Échec',
        };

        $decision = $pourcentageGeneral >= 50 ? 'ADMIS(E)' : 'AJOURNÉ(E)';

        $sexe = match ($enrollment->user->genre ?? null) {
            'M' => 'Masculin',
            'F' => 'Féminin',
            default => '—',
        };

        $reference = 'RC-' . $enrollment->id . '-' . str_replace(' ', '', $enrollment->academicYear->name ?? '');

        $meta = [
            'etudiant' => $enrollment->user->name ?? '--',
            'matricule' => $enrollment->user->matricule ?? '--',
            'promotion' => $enrollment->promotion->name ?? '--',
            'annee_academique' => $enrollment->academicYear->name ?? '--',
            'moyenne_sur_20' => round($moyenneSur20, 2),
            'mention' => $mention,
            'decision' => $decision,
        ];

        return $documents->generate(
            type: 'releve',
            view: 'pdf.releve',
            viewData: [
                'enrollment' => $enrollment,
                'lines' => $lines,
                'totalCredits' => $totalCredits,
                'totalPoints' => round($totalPoints, 2),
                'pourcentageGeneral' => round($pourcentageGeneral, 2),
                'moyenneSur20' => round($moyenneSur20, 2),
                'mention' => $mention,
                'decision' => $decision,
                'sexe' => $sexe,
                'reference' => $reference,
            ],
            meta: $meta,
            documentable: $enrollment,
        );
    }
}
