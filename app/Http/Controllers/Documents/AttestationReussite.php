<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Services\DocumentService;

class AttestationReussite extends Controller
{
    public function __invoke(Enrollment $enrollment, DocumentService $documents)
    {
        $enrollment->load(['user', 'faculty', 'department', 'promotion', 'academicYear']);

        $assignments = CourseAssignment::where('promotion_id', $enrollment->promotion_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->get();

        $grades = Grade::whereIn('course_assignment_id', $assignments->pluck('id'))
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
        $moyenneSur20 = round($pourcentageGeneral * 20 / 100, 2);

        $mention = match (true) {
            $pourcentageGeneral >= 80 => 'Grande Distinction',
            $pourcentageGeneral >= 70 => 'Distinction',
            $pourcentageGeneral >= 50 => 'Satisfaction',
            default => 'Échec',
        };

        $decision = $pourcentageGeneral >= 50 ? 'ADMIS(E)' : 'AJOURNÉ(E)';

        // Garde-fou : impossible de délivrer une attestation de réussite
        // à un(e) étudiant(e) qui n'a pas été déclaré(e) admis(e)
        if ($decision !== 'ADMIS(E)') {
            return response()->view('documents.blocked', [
                'message' => "Impossible de générer une attestation de réussite : l'étudiant(e) n'a pas été déclaré(e) admis(e) pour cette année académique.",
            ]);
        }

        $sexe = match ($enrollment->user->genre ?? null) {
            'M' => 'Masculin',
            'F' => 'Féminin',
            default => '—',
        };

        $meta = [
            'etudiant' => $enrollment->user->name ?? '--',
            'matricule' => $enrollment->user->matricule ?? '--',
            'promotion' => $enrollment->promotion->name ?? '--',
            'annee_academique' => $enrollment->academicYear->name ?? '--',
            'moyenne_sur_20' => $moyenneSur20,
            'mention' => $mention,
            'decision' => $decision,
        ];

        return $documents->generate(
            type: 'attestation_reussite',
            view: 'pdf.attestation-reussite',
            viewData: [
                'enrollment' => $enrollment,
                'sexe' => $sexe,
                'pourcentageGeneral' => round($pourcentageGeneral, 2),
                'moyenneSur20' => $moyenneSur20,
                'mention' => $mention,
                'decision' => $decision,
            ],
            meta: $meta,
            documentable: $enrollment,
        );
    }
}
