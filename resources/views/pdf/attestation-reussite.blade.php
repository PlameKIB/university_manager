<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('pdf.partials.style')
</head>
<body>

    @include('pdf.partials.header')

    <div class="doc-title">Attestation de réussite</div>
    <div class="doc-subtitle">Année académique {{ $enrollment->academicYear->name ?? '--' }}</div>

    <p class="paragraph">
        Le Secrétaire Académique de {{ config('app.name') }} soussigné(e) atteste par la présente que :
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
        a valablement satisfait aux épreuves d'évaluation de l'année académique
        <strong>{{ $enrollment->academicYear->name ?? '--' }}</strong> et a obtenu une moyenne générale
        de <strong>{{ $moyenneSur20 }} / 20</strong> ({{ $pourcentageGeneral }}%), avec la mention :
    </p>

    <div class="summary-box text-center">
        <div class="value">{{ $mention }}</div>
        <div class="label">Décision du jury : {{ $decision }}</div>
    </div>

    <p class="paragraph">
        En conséquence, l'intéressé(e) est déclaré(e) <strong>ADMIS(E)</strong> et autorisé(e) à
        poursuivre son cursus académique. La présente attestation est délivrée pour servir et valoir
        ce que de droit.
    </p>

    <table class="signature-box">
        <tr>
            <td>
                <div class="signature-line">Le Président du Jury</div>
            </td>
            <td>
                <div class="signature-line">
                    Fait à Goma, le {{ now()->translatedFormat('d F Y') }}<br>
                    Le Doyen / Directeur
                </div>
            </td>
        </tr>
    </table>

    @include('pdf.partials.footer-qr')

</body>
</html>
