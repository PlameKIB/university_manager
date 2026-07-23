<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Services\DocumentService;

class AttestationFrequentation extends Controller
{
    public function __invoke(Enrollment $enrollment, DocumentService $documents)
    {
        $enrollment->load(['user', 'faculty', 'department', 'promotion', 'academicYear']);

        // On ne délivre une attestation de fréquentation que pour une inscription active
        if ($enrollment->status !== 'active') {
            return response()->view('documents.blocked', [
                'message' => "Une attestation de fréquentation ne peut être délivrée que pour une inscription active.",
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
            'statut' => 'Inscription active',
        ];

        return $documents->generate(
            type: 'attestation_frequentation',
            view: 'pdf.attestation-frequentation',
            viewData: [
                'enrollment' => $enrollment,
                'sexe' => $sexe,
            ],
            meta: $meta,
            documentable: $enrollment,
        );
    }
}
