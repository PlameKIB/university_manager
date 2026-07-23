<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('pdf.partials.style')
</head>
<body>

    @include('pdf.partials.header')

    <div class="doc-title">Attestation de fréquentation</div>
    <div class="doc-subtitle">Certificat de scolarité &middot; {{ $enrollment->academicYear->name ?? '--' }}</div>

    <p class="paragraph">
        Le/la {{ $signataireTitre ?? 'Secrétaire Académique' }} de {{ config('app.name') }}
        soussigné(e), atteste par la présente que :
    </p>

    <table class="info-table">
        <tr>
            <td class="label">Nom complet</td>
            <td><strong>{{ $enrollment->user->name ?? '--' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Matricule</td>
            <td>{{ $enrollment->user->matricule ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Sexe</td>
            <td>{{ $sexe }}</td>
        </tr>
        @if($enrollment->user->date_naissance)
        <tr>
            <td class="label">Né(e) le</td>
            <td>{{ \Illuminate\Support\Carbon::parse($enrollment->user->date_naissance)->translatedFormat('d F Y') }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Faculté / Département</td>
            <td>{{ $enrollment->faculty->name ?? '--' }} @if($enrollment->department) / {{ $enrollment->department->name }} @endif</td>
        </tr>
        <tr>
            <td class="label">Promotion</td>
            <td>{{ $enrollment->promotion->name ?? '--' }}</td>
        </tr>
    </table>

    <p class="paragraph">
        est régulièrement inscrit(e) et fréquente assidûment les enseignements dispensés au sein
        de notre institution au titre de l'année académique <strong>{{ $enrollment->academicYear->name ?? '--' }}</strong>,
        en qualité d'étudiant(e) régulier(ère) dans la promotion sus-mentionnée.
    </p>

    <p class="paragraph">
        La présente attestation est délivrée à l'intéressé(e) pour servir et valoir ce que de droit.
    </p>

    <table class="signature-box">
        <tr>
            <td></td>
            <td>
                <div class="signature-line">
                    Fait à Goma, le {{ now()->translatedFormat('d F Y') }}<br>
                    Le Secrétaire Académique
                </div>
            </td>
        </tr>
    </table>

    @include('pdf.partials.footer-qr')

</body>
</html>
