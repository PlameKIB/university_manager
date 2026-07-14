<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Reçu {{ $payment->receipt_number }}</title>
    <style>
        @page { size: A5; margin: 12mm; }

        * { box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            font-size: 12px;
            -webkit-font-smoothing: antialiased;
        }

        .receipt {
            max-width: 480px;
            margin: 0 auto;
            padding: 0;
            position: relative;
        }

        /* ---------- HEADER ---------- */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 22px 16px;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            border-radius: 10px 10px 0 0;
        }

        .header .institution h1 {
            font-size: 16px;
            margin: 0 0 3px;
            font-weight: 700;
            letter-spacing: .3px;
        }

        .header .institution p {
            font-size: 9.5px;
            margin: 0;
            color: #cbd5e1;
        }

        .header .badge {
            text-align: right;
        }

        .header .badge .type {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94a3b8;
            margin: 0 0 3px;
        }

        .header .badge .number {
            font-size: 13px;
            font-weight: 700;
            color: #facc15;
        }

        /* ---------- STRIP: date / statut ---------- */
        .strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 22px;
            background: #f1f5f9;
            font-size: 10.5px;
            color: #475569;
            border-bottom: 1px solid #e2e8f0;
        }

        .strip .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-weight: 700;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ---------- BODY ---------- */
        .body { padding: 20px 22px 4px; }

        .section-label {
            font-size: 9.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin: 0 0 8px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px 18px;
            margin-bottom: 20px;
        }

        .info-cell .label {
            display: block;
            font-size: 9.5px;
            color: #94a3b8;
            margin-bottom: 2px;
        }

        .info-cell .value {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: #0f172a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        thead th {
            text-align: left;
            background: #0f172a;
            color: #fff;
            padding: 8px 10px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        thead th:last-child { text-align: right; }

        thead th:first-child { border-radius: 6px 0 0 0; }
        thead th:last-child { border-radius: 0 6px 0 0; }

        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 11.5px;
            color: #334155;
        }

        tbody tr:nth-child(even) td {
            background: #f8fafc;
        }

        tbody td:last-child {
            text-align: right;
            font-weight: 600;
            color: #0f172a;
        }

        tfoot td {
            padding: 12px 10px;
            font-weight: 700;
            font-size: 13.5px;
            background: #0f172a;
            color: #fff;
        }

        tfoot td:first-child { border-radius: 0 0 0 6px; }

        tfoot td:last-child {
            text-align: right;
            color: #facc15;
            border-radius: 0 0 6px 0;
        }

        .note {
            font-size: 10.5px;
            color: #64748b;
            font-style: italic;
            background: #f8fafc;
            border-left: 3px solid #cbd5e1;
            padding: 8px 12px;
            margin: 16px 0;
            border-radius: 0 4px 4px 0;
        }

        /* ---------- SIGNATURES ---------- */
        .footer {
            display: flex;
            justify-content: space-between;
            margin-top: 36px;
            padding: 0 6px;
        }

        .signature {
            text-align: center;
            width: 45%;
        }

        .signature .line {
            margin-top: 32px;
            border-top: 1px solid #cbd5e1;
        }

        .signature .role {
            margin-top: 6px;
            font-size: 10px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ---------- STAMP / FOOTER META ---------- */
        .stamp {
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            margin-top: 26px;
            padding-top: 12px;
            border-top: 1px dashed #e2e8f0;
        }

        .stamp strong {
            color: #64748b;
        }

        @media print {
            .no-print { display: none; }
            .receipt { box-shadow: none; }
        }

        @media screen {
            body { background: #e2e8f0; padding: 30px 0; }
            .receipt {
                background: #fff;
                box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.08);
                border-radius: 10px;
                overflow: hidden;
            }
        }
    </style>
</head>
<body>

    <div class="receipt">

        <div class="header">
            <div class="institution">
                <h1>{{ config('app.name', 'Institution') }}</h1>
                <p>Reçu de paiement académique</p>
            </div>
            <div class="badge">
                <p class="type">Reçu N°</p>
                <p class="number">{{ $payment->receipt_number }}</p>
            </div>
        </div>

        <div class="strip">
            <span>{{ \Carbon\Carbon::parse($payment->payment_date)->translatedFormat('d F Y') }}</span>
            <span class="status">Payé</span>
        </div>

        <div class="body">

            <p class="section-label">Informations de l'étudiant</p>
            <div class="info-grid">
                <div class="info-cell">
                    <span class="label">Nom complet</span>
                    <span class="value">{{ $payment->enrollment->user->name }}</span>
                </div>
                <div class="info-cell">
                    <span class="label">Matricule</span>
                    <span class="value">{{ $payment->enrollment->user->matricule }}</span>
                </div>
                <div class="info-cell">
                    <span class="label">Filière</span>
                    <span class="value">{{ $payment->enrollment->faculty->name ?? '--' }}</span>
                </div>
                <div class="info-cell">
                    <span class="label">Promotion</span>
                    <span class="value">{{ $payment->enrollment->promotion->name ?? '--' }}</span>
                </div>
                <div class="info-cell" style="grid-column: 1 / -1;">
                    <span class="label">Année académique</span>
                    <span class="value">{{ $payment->enrollment->academicYear->name ?? '--' }}</span>
                </div>
            </div>

            <p class="section-label">Détail du paiement</p>
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
                    <div class="role">Caissier</div>
                </div>
                <div class="signature">
                    <div class="line"></div>
                    <div class="role">Étudiant</div>
                </div>
            </div>

            <div class="stamp">
                Document généré le <strong>{{ now()->format('d/m/Y à H:i') }}</strong> —
                Ce reçu fait foi de paiement et doit être conservé par l'étudiant.
            </div>

        </div>
    </div>

    <div class="no-print" style="text-align:center; margin-top:24px;">
        <button onclick="window.print()" style="padding:10px 24px;background:#0f172a;color:#fff;
                border:none;border-radius:8px;font-size:13px;cursor:pointer;">
            Imprimer
        </button>
    </div>

</body>
</html>