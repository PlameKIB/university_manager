<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('pdf.partials.style')
</head>
<body>

    @include('pdf.partials.header')

    <div class="doc-title">Relevé de notes</div>
    <div class="doc-subtitle">Réf. {{ $reference }}</div>

    <table class="info-table">
        <tr>
            <td class="label">Étudiant(e)</td>
            <td>{{ $enrollment->user->name ?? '--' }}</td>
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
            <td class="label">Promotion</td>
            <td>{{ $enrollment->promotion->name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Faculté / Département</td>
            <td>{{ $enrollment->faculty->name ?? '--' }} @if($enrollment->department) / {{ $enrollment->department->name }} @endif</td>
        </tr>
        <tr>
            <td class="label">Année académique</td>
            <td>{{ $enrollment->academicYear->name ?? '--' }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>Cours</th>
                <th class="text-center">Crédit</th>
                <th class="text-center">TP</th>
                <th class="text-center">Interro</th>
                <th class="text-center">Examen</th>
                <th class="text-center">Cote</th>
                <th class="text-center">%</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lines as $line)
                <tr>
                    <td>{{ $line->course->name ?? '--' }}</td>
                    <td class="text-center">{{ $line->credit }}</td>
                    <td class="text-center">{{ $line->tp ?? '-' }}</td>
                    <td class="text-center">{{ $line->interro ?? '-' }}</td>
                    <td class="text-center">{{ $line->examen ?? '-' }}</td>
                    <td class="text-center">{{ $line->cote_finale }} / {{ $line->bareme_total }}</td>
                    <td class="text-center">{{ $line->pourcentage }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="info-table" style="margin-top:16px;">
        <tr>
            <td class="label">Total des crédits</td>
            <td>{{ $totalCredits }}</td>
        </tr>
        <tr>
            <td class="label">Moyenne générale</td>
            <td>{{ $moyenneSur20 }} / 20 &nbsp; ({{ $pourcentageGeneral }}%)</td>
        </tr>
        <tr>
            <td class="label">Mention</td>
            <td>{{ $mention }}</td>
        </tr>
        <tr>
            <td class="label">Décision</td>
            <td>
                <span class="badge {{ $decision === 'ADMIS(E)' ? 'badge-success' : 'badge-danger' }}">
                    {{ $decision }}
                </span>
            </td>
        </tr>
    </table>

    <table class="signature-box">
        <tr>
            <td>
                <div class="signature-line">Le Secrétaire Académique</div>
            </td>
            <td>
                <div class="signature-line">Le Doyen / Directeur</div>
            </td>
        </tr>
    </table>

    @include('pdf.partials.footer-qr')

</body>
</html>
