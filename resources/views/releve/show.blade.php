<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Relevé des côtes — {{ $enrollment->user->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 16mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Georgia, 'Times New Roman', serif;
            color: #111827;
            margin: 0;
            padding: 0;
            font-size: 12.5px;
            position: relative;
        }

        .sheet {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* Filigrane de sécurité */
        .watermark {
            position: fixed;
            top: 45%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-35deg);
            font-size: 70px;
            font-weight: bold;
            color: rgba(17, 24, 39, 0.05);
            white-space: nowrap;
            z-index: 0;
            letter-spacing: 4px;
            text-transform: uppercase;
        }

        /* Bande tricolore RDC */
        .flag-bar {
            height: 5px;
            display: flex;
            margin-bottom: 14px;
        }

        .flag-bar span {
            flex: 1;
        }

        .flag-bar .blue {
            background: #007fff;
        }

        .flag-bar .yellow {
            background: #f7d618;
        }

        .flag-bar .red {
            background: #ce1021;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header .country {
            font-size: 13px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .header .ministry {
            font-size: 11px;
            text-transform: uppercase;
            margin-top: 2px;
            color: #374151;
        }

        .header .divider {
            width: 120px;
            border-top: 1px solid #111827;
            margin: 8px auto;
        }

        .header .institution {
            font-size: 17px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 6px;
        }

        .header .faculty {
            font-size: 12px;
            margin-top: 2px;
            color: #374151;
        }

        .header-row {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 10px;
        }

        .header-row .logo {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
            color: #111827;
        }

        .header-row .header-text {
            flex: 1;
            text-align: center;
            font-size: 14px;
        }

        .doc-title-wrap {
            text-align: center;
            margin: 22px 0 18px;
        }

        .doc-title {
            display: inline-block;
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-top: 2px solid #111827;
            border-bottom: 2px solid #111827;
            padding: 6px 22px;
        }

        .reference {
            text-align: right;
            font-size: 10.5px;
            color: #4b5563;
            margin-bottom: 6px;
        }

        /* Bloc identité + photo */
        .identity {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .identity-fields {
            flex: 1;
            font-size: 12.5px;
        }

        .identity-fields .field {
            display: flex;
            border-bottom: 1px dotted #9ca3af;
            padding: 4px 0;
        }

        .identity-fields .field .label {
            width: 180px;
            color: #4b5563;
        }

        .identity-fields .field .value {
            font-weight: bold;
        }

        .photo-box {
            width: 100px;
            height: 130px;
            border: 1px solid #111827;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 9.5px;
            color: #9ca3af;
            text-align: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        table.grades {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }

        table.grades th,
        table.grades td {
            border: 1px solid #111827;
            padding: 6px 8px;
        }

        table.grades thead th {
            background: #f3f4f6;
            text-transform: uppercase;
            font-size: 10.5px;
            text-align: center;
        }

        table.grades thead th.left {
            text-align: left;
        }

        table.grades td.num {
            text-align: center;
        }

        table.grades td.not-graded {
            text-align: center;
            font-style: italic;
            color: #9ca3af;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 18px 0 26px;
        }

        .summary-table td {
            border: 1px solid #111827;
            padding: 8px 10px;
            font-size: 12px;
        }

        .summary-table td.label {
            background: #f3f4f6;
            font-weight: bold;
            width: 45%;
        }

        .summary-table td.value {
            font-weight: bold;
            width: 9%;
            text-align: center;
        }

        .decision-row td {
            font-size: 14px;
            text-align: center;
            letter-spacing: 1px;
        }

        .decision-row .admis {
            color: #065f46;
        }

        .decision-row .ajourne {
            color: #991b1b;
        }

        .place-date {
            font-size: 11.5px;
            margin: 30px 0 10px;
        }

        .signatures {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 20px;
        }

        .signature-block {
            width: 230px;
            text-align: center;
            font-size: 11px;
        }

        .signature-block .line {
            margin-top: 46px;
            border-top: 1px solid #111827;
            padding-top: 4px;
        }

        .seal {
            width: 100px;
            height: 100px;
            border: 2px dashed #9ca3af;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 9.5px;
            color: #9ca3af;
        }

        .generated-note {
            text-align: center;
            font-size: 9.5px;
            color: #9ca3af;
            margin-top: 34px;
        }

        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="watermark">{{ config('app.name', 'INSTITUTION') }}</div>

    <div class="sheet">

        <div class="flag-bar">
            <span class="blue"></span><span class="yellow"></span><span class="red"></span>
        </div>

        <div class="header-row">
            <x-app-logo-icon class="logo" />

            <div class="header-text">
                <div class="country">République Démocratique du Congo</div>
                <div class="ministry">Ministère de l'Enseignement Supérieur et Universitaire</div>
                <div class="divider"></div>
                <div class="institution">{{ config('app.name', 'Institution') }}</div>
                <div class="faculty">
                    Faculté de {{ $enrollment->faculty->name ?? '—' }}
                    — Département de {{ $enrollment->department->name ?? '—' }}
                </div>
            </div>

            {{-- Espace réservé symétrique, pour garder le texte bien centré --}}
            <div class="logo" style="visibility:hidden;"></div>
        </div>

        <div class="reference">N° {{ $reference }}</div>

        <div class="doc-title-wrap">
            <span class="doc-title">Relevé des Côtes</span>
        </div>

        <div class="identity">
            <div class="identity-fields">
                <div class="field">
                    <span class="label">Nom, Post-nom et Prénom</span>
                    <span class="value">{{ $enrollment->user->name }}</span>
                </div>
                <div class="field">
                    <span class="label">Matricule</span>
                    <span class="value">{{ $enrollment->user->matricule }}</span>
                </div>
                <div class="field">
                    <span class="label">Sexe</span>
                    <span class="value">{{ $sexe }}</span>
                </div>
                <div class="field">
                    <span class="label">Promotion</span>
                    <span class="value">{{ $enrollment->promotion->name ?? '—' }}</span>
                </div>
                <div class="field">
                    <span class="label">Année académique</span>
                    <span class="value">{{ $enrollment->academicYear->name ?? '—' }}</span>
                </div>
            </div>

            <div class="photo-box">
                @if($enrollment->user->photo)
                    <img src="{{ asset('storage/' . $enrollment->user->photo) }}" alt="Photo">
                @else
                    Photo
                @endif
            </div>
        </div>

        <table class="grades">
            <thead>
                <tr>
                    <th class="left">Enseignements</th>
                    <th>Crédit</th>
                    <th>TP</th>
                    <th>Interro</th>
                    <th>Examen</th>
                    <th>Côte finale</th>
                    <th>%</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lines as $line)
                    <tr>
                        <td>{{ $line->course->intitule }}</td>
                        <td class="num">{{ $line->credit }}</td>

                        @if($line->is_graded)
                            <td class="num">{{ $line->tp ?? '—' }}</td>
                            <td class="num">{{ $line->interro ?? '—' }}</td>
                            <td class="num">{{ $line->examen ?? '—' }}</td>
                            <td class="num">{{ $line->cote_finale }} / {{ $line->bareme_total }}</td>
                            <td class="num">{{ $line->pourcentage }}%</td>
                        @else
                            <td colspan="5" class="not-graded">Non côté</td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">
                            Aucun cours attribué à cette promotion pour cette année académique.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <table class="summary-table">
            <tr>
                <td class="label">Total des crédits</td>
                <td class="value">{{ $totalCredits }}</td>
                <td class="label">Pourcentage général</td>
                <td class="value">{{ $pourcentageGeneral }}%</td>
            </tr>
            <tr>
                <td class="label">Moyenne générale</td>
                <td class="value">{{ $moyenneSur20 }} / 20</td>
                <td class="label">Mention</td>
                <td class="value">{{ $mention }}</td>
            </tr>
            <tr class="decision-row">
                <td colspan="4" class="{{ $decision === 'ADMIS(E)' ? 'admis' : 'ajourne' }}">
                    Décision du jury : {{ $decision }}
                </td>
            </tr>
        </table>

        <div class="place-date">
            Fait à _____________________, le {{ now()->format('d/m/Y') }}
        </div>

        <div class="signatures">
            <div class="signature-block">
                <div class="line">Le Secrétaire Général Académique</div>
            </div>

            <div class="seal">Sceau de<br>l'institution</div>

            <div class="signature-block">
                <div class="line">Le Doyen de la Faculté</div>
            </div>
        </div>

        <div class="generated-note">
            Document généré électroniquement le {{ now()->format('d/m/Y à H:i') }}
        </div>

    </div>

    <div class="no-print" style="text-align:center; margin-top:24px; position: relative; z-index: 1;">
        <button onclick="window.print()" style="padding:10px 24px;background:#111827;color:#fff;
                border:none;border-radius:4px;font-size:13px;cursor:pointer;">
            Imprimer / Enregistrer en PDF
        </button>
    </div>

</body>

</html>