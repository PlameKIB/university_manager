<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu {{ $payment->receipt_number }}</title>
    <style>
        @page { size: A5; margin: 15mm; }

        * { box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }

        .receipt {
            max-width: 480px;
            margin: 0 auto;
            padding: 24px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 4px;
            color: #4f46e5;
        }

        .header p {
            font-size: 11px;
            color: #6b7280;
            margin: 2px 0;
        }

        .receipt-title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 16px 0;
            color: #374151;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 16px;
            color: #4b5563;
        }

        .info-block {
            background: #f9fafb;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .info-block .row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .info-block .label {
            color: #6b7280;
        }

        .info-block .value {
            font-weight: 600;
            color: #1f2937;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 16px;
        }

        thead th {
            text-align: left;
            background: #4f46e5;
            color: #fff;
            padding: 8px 10px;
            font-size: 11px;
            text-transform: uppercase;
        }

        thead th:last-child { text-align: right; }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        tbody td:last-child { text-align: right; font-weight: 600; }

        tfoot td {
            padding: 10px;
            font-weight: bold;
            font-size: 13px;
        }

        tfoot td:last-child {
            text-align: right;
            color: #4f46e5;
        }

        .note {
            font-size: 11px;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 20px;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            font-size: 11px;
            color: #6b7280;
        }

        .signature {
            text-align: center;
        }

        .signature .line {
            margin-top: 36px;
            border-top: 1px solid #9ca3af;
            width: 140px;
        }

        .stamp {
            text-align: center;
            font-size: 10px;
            color: #9ca3af;
            margin-top: 24px;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>

    <div class="receipt">

        <div class="header">
            <h1>{{ config('app.name', 'Institution') }}</h1>
            <p>Reçu de paiement académique</p>
        </div>

        <div class="receipt-title">Reçu de paiement</div>

        <div class="meta">
            <span>N° {{ $payment->receipt_number }}</span>
            <span>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</span>
        </div>

        <div class="info-block">
            <div class="row">
                <span class="label">Étudiant</span>
                <span class="value">
                    {{ $payment->enrollment->user->name }}
                </span>
            </div>
            <div class="row">
                <span class="label">Matricule</span>
                <span class="value">{{ $payment->enrollment->user->matricule }}</span>
            </div>
            <div class="row">
                <span class="label">Filière</span>
                <span class="value">{{ $payment->enrollment->faculty->name ?? '--' }}</span>
            </div>
            <div class="row">
                <span class="label">Promotion</span>
                <span class="value">{{ $payment->enrollment->promotion->name ?? '--' }}</span>
            </div>
            <div class="row">
                <span class="label">Année académique</span>
                <span class="value">{{ $payment->enrollment->academicYear->name ?? '--' }}</span>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Frais</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payment->items as $item)
                    <tr>
                        <td>{{ $item->fee->name ?? '--' }}</td>
                        <td>{{ number_format($item->amount, 2, ',', ' ') }} $</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td>Total payé</td>
                    <td>{{ number_format($payment->total_amount, 2, ',', ' ') }} $</td>
                </tr>
            </tfoot>
        </table>

        @if($payment->note)
            <div class="note">Note : {{ $payment->note }}</div>
        @endif

        <div class="footer">
            <div class="signature">
                <div class="line"></div>
                Caissier
            </div>
            <div class="signature">
                <div class="line"></div>
                Étudiant
            </div>
        </div>

        <div class="stamp">
            Document généré le {{ now()->format('d/m/Y à H:i') }}
        </div>

    </div>

    <div class="no-print" style="text-align:center; margin-top:24px;">
        <button onclick="window.print()" style="padding:10px 24px;background:#4f46e5;color:#fff;
                border:none;border-radius:8px;font-size:13px;cursor:pointer;">
            Imprimer
        </button>
    </div>

</body>
</html>