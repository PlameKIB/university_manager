<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('pdf.partials.style')
</head>
<body>

    @include('pdf.partials.header')

    <div class="doc-title">Palmarès de promotion</div>
    <div class="doc-subtitle">
        {{ $promotion->name ?? '--' }} &middot; Année académique {{ $academicYear->name ?? '--' }}
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center">Rang</th>
                <th>Nom &amp; Matricule</th>
                <th class="text-center">Moyenne / 20</th>
                <th class="text-center">%</th>
                <th>Mention</th>
                <th class="text-center">Décision</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ranking as $row)
                <tr>
                    <td class="text-center"><strong>{{ $row['rang'] }}</strong></td>
                    <td>
                        {{ $row['user']->name ?? '--' }}<br>
                        <span style="color:#6b7280;font-size:9px;">{{ $row['user']->matricule ?? '--' }}</span>
                    </td>
                    <td class="text-center">{{ $row['moyenne'] }} / 20</td>
                    <td class="text-center">{{ $row['pourcentage'] }}%</td>
                    <td>{{ $row['mention'] }}</td>
                    <td class="text-center">
                        <span class="badge {{ $row['decision'] === 'ADMIS(E)' ? 'badge-success' : 'badge-danger' }}">
                            {{ $row['decision'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
