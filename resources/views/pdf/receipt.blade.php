<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @include('pdf.partials.style')
</head>
<body>

    @include('pdf.partials.header')

    <div class="doc-title">Reçu de paiement</div>
    <div class="doc-subtitle">N° {{ $payment->receipt_number }}</div>

    <table class="info-table">
        <tr>
            <td class="label">Étudiant(e)</td>
            <td>{{ $payment->enrollment->user->name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Matricule</td>
            <td>{{ $payment->enrollment->user->matricule ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Promotion</td>
            <td>{{ $payment->enrollment->promotion->name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Année académique</td>
            <td>{{ $payment->enrollment->academicYear->name ?? '--' }}</td>
        </tr>
        <tr>
            <td class="label">Date de paiement</td>
            <td>{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th>Frais</th>
                <th class="text-right">Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payment->items as $item)
                <tr>
                    <td>{{ $item->fee->name ?? 'Frais' }}</td>
                    <td class="text-right">{{ number_format($item->amount, 2, ',', ' ') }} $</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-box text-right">
        <div class="label">Montant total payé</div>
        <div class="value">{{ number_format($payment->total_amount, 2, ',', ' ') }} $</div>
    </div>

    @if($payment->note)
        <p class="paragraph"><strong>Note :</strong> {{ $payment->note }}</p>
    @endif

    <table class="signature-box">
        <tr>
            <td>
                <div class="signature-line">Le caissier / la caissière</div>
            </td>
            <td>
                <div class="signature-line">Cachet de l'institution</div>
            </td>
        </tr>
    </table>

    @include('pdf.partials.footer-qr')

</body>
</html>
