<?php

namespace App\Services;

use App\Models\GeneratedDocument;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DocumentService
{
    /**
     * Génère un PDF officiel, l'enregistre pour traçabilité (code + hash + auteur)
     * et l'expose immédiatement au navigateur (visualisation/téléchargement).
     *
     * @param  string      $type         Clé du type de document (voir GeneratedDocument::TYPES)
     * @param  string      $view         Vue blade à utiliser pour le rendu du PDF
     * @param  array       $viewData     Données nécessaires au template
     * @param  array       $meta         Résumé des données clés à conserver pour audit (léger, sans objets Eloquent)
     * @param  mixed|null  $documentable Modèle source du document (Payment, Enrollment, Promotion...)
     */
    public function generate(string $type, string $view, array $viewData, array $meta = [], $documentable = null): Response
    {
        $code = $this->generateUniqueCode($type);

        $verificationUrl = route('documents.verify', $code);

        // Le QR est généré en SVG puis encodé en data-uri : aucune dépendance
        // à Imagick/GD, et il fonctionne hors-ligne, ce qui est essentiel
        // pour un déploiement en réseau local sans accès internet garanti.
        $qrSvg = QrCode::size(140)->margin(1)->generate($verificationUrl);
        $qrDataUri = 'data:image/svg+xml;base64,' . base64_encode($qrSvg);

        // Empreinte du document : liée au code + aux données réellement utilisées
        // (notes, montants...) au moment de l'émission. Si ces données changent
        // plus tard en base, ce hash reste la preuve de ce qui a été délivré ce jour-là.
        $hash = hash('sha256', $code . '|' . json_encode($meta, JSON_UNESCAPED_UNICODE));

        $document = GeneratedDocument::create([
            'code' => $code,
            'type' => $type,
            'documentable_type' => $documentable ? get_class($documentable) : null,
            'documentable_id' => $documentable->id ?? null,
            'hash' => $hash,
            'payload' => $meta,
            'generated_by' => auth()->id(),
            'ip_address' => request()->ip(),
        ]);

        $viewData['verificationCode'] = $code;
        $viewData['verificationUrl'] = $verificationUrl;
        $viewData['qrDataUri'] = $qrDataUri;
        $viewData['generatedAt'] = now();
        $viewData['documentHash'] = $hash;

        $pdf = Pdf::loadView($view, $viewData)->setPaper('a4', 'portrait');

        return $pdf->stream(Str::slug($type . '-' . $code) . '.pdf');
    }

    protected function generateUniqueCode(string $type): string
    {
        $prefix = match ($type) {
            'recu' => 'REC',
            'releve' => 'REL',
            'attestation_frequentation' => 'ATF',
            'attestation_reussite' => 'ATR',
            'palmares' => 'PAL',
            default => 'DOC',
        };

        do {
            $code = sprintf('%s-%s-%s', $prefix, now()->format('Y'), strtoupper(Str::random(6)));
        } while (GeneratedDocument::where('code', $code)->exists());

        return $code;
    }
}
