<style>
    @page {
        margin: 90px 38px 110px 38px;
    }

    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        color: #1f2937;
        line-height: 1.55;
        margin: 0;
        padding: 16px 22px 18px 22px;
        position: relative;
        z-index: 1;
    }

    .page-frame {
        position: fixed;
        left: 16px;
        right: 16px;
        top: 16px;
        bottom: 16px;
        border: 2px solid #1e3a5f;
        border-radius: 8px;
        pointer-events: none;
        z-index: 0;
    }

    .page-frame-inner {
        position: fixed;
        left: 26px;
        right: 26px;
        top: 26px;
        bottom: 26px;
        border: 1px solid #dbe3ee;
        border-radius: 6px;
        pointer-events: none;
        z-index: 0;
    }

    /* ============ EN-TETE ============ */
    .header {
        position: fixed;
        top: -86px;
        left: 0;
        right: 0;
        height: 96px;
        text-align: center;
        background: transparent;
    }

    .flag-bar {
        display: flex;
        height: 4px;
        margin-bottom: 10px;
        border-radius: 2px;
        overflow: hidden;
    }

    .flag-bar span {
        flex: 1;
    }

    .flag-bar .blue { background: #007fff; }
    .flag-bar .yellow { background: #f7d618; }
    .flag-bar .red { background: #ce1021; }

    .header-row {
        display: flex;
        align-items: center;
        gap: 14px;
        border-bottom: 2px solid #1e3a5f;
        padding-bottom: 9px;
        width: calc(100% - 28px);
        margin: 0 auto;
        box-sizing: border-box;
        margin-bottom: 2px;
        padding-bottom: 10px;
    }

    .header .app-logo {
        width: 62px;
        height: 62px;
        object-fit: contain;
        flex-shrink: 0;
    }

    .header .app-logo.spacer {
        visibility: hidden;
    }

    .header .header-text {
        flex: 1;
        text-align: center;
    }

    .header .country {
        font-family: 'DejaVu Serif', serif;
        font-size: 10px;
        font-weight: bold;
        color: #1e3a5f;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .header .ministry {
        font-size: 8px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-top: 1px;
    }

    .header .institution {
        font-family: 'DejaVu Serif', serif;
        font-size: 16px;
        font-weight: bold;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-top: 4px;
    }

    .header .sub {
        font-size: 9px;
        color: #6b7280;
        margin-top: 2px;
        font-style: italic;
    }

    /* ============ PIED DE PAGE ============ */
    .footer {
        position: fixed;
        bottom: -100px;
        left: 0;
        right: 0;
        height: 92px;
        padding-top: 12px;
    }

    .footer-rule {
        border-top: 1px solid #c7ceda;
        margin-bottom: 8px;
    }

    .footer table {
        width: 100%;
    }

    .footer .qr-cell {
        width: 58px;
        text-align: left;
        vertical-align: middle;
    }

    .footer .qr-cell img {
        width: 52px;
        height: 52px;
        border: 1px solid #e5e7eb;
        padding: 3px;
        background: #fff;
    }

    .footer .text-cell {
        vertical-align: middle;
        padding-left: 12px;
        font-size: 8.7px;
        color: #6b7280;
        line-height: 1.5;
    }

    .footer .code {
        display: inline-block;
        font-weight: bold;
        color: #1e3a5f;
        background: #eef2f7;
        border: 0.5px solid #c7ceda;
        border-radius: 3px;
        padding: 1px 6px;
        font-size: 9.5px;
        letter-spacing: 0.3px;
    }

    /* ============ TITRE DU DOCUMENT ============ */
    .doc-title {
        text-align: center;
        font-family: 'DejaVu Serif', serif;
        font-size: 21px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 14px 0 2px 0;
        color: #1e3a5f;
    }

    .doc-title-rule {
        width: 130px;
        height: 2px;
        background: #1e3a5f;
        margin: 6px auto 4px auto;
    }

    .doc-subtitle {
        text-align: center;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 22px;
        font-weight: bold;
        letter-spacing: 0.3px;
        padding-top: 10px;
    }

    /* ============ TABLEAUX D'INFORMATIONS ============ */
    .identity-table {
        margin-bottom: 18px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .info-table td {
        padding: 8px 10px;
        font-size: 12px;
        border-bottom: 0.5px solid #e5e7eb;
    }

    .info-table tr:last-child td {
        border-bottom: none;
    }

    .info-table td.label {
        width: 38%;
        color: #4b5568;
        font-weight: bold;
        background: #f7f8fa;
        border-right: 0.5px solid #e5e7eb;
    }

    /* ============ TABLEAU DE DONNEES (notes, frais...) ============ */
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .data-table th {
        background: #1e3a5f;
        color: #ffffff;
        font-size: 9.5px;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        padding: 8px 7px;
        text-align: left;
    }

    .data-table td {
        padding: 7px 7px;
        font-size: 11px;
        border-bottom: 0.5px solid #e5e7eb;
        vertical-align: middle;
    }

    .data-table tbody tr:nth-child(even) {
        background: #f7f8fa;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    /* ============ CARTES RESUME ============ */
    .summary-grid {
        display: table;
        width: 100%;
        margin: 18px 0;
        border-collapse: separate;
        border-spacing: 8px 0;
    }

    .summary-card {
        display: table-cell;
        width: 25%;
        padding: 12px 8px;
        background: #f7f8fa;
        border: 0.5px solid #dde2ea;
        text-align: center;
    }

    .summary-label {
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-size: 8.5px;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 14px;
        font-weight: bold;
        color: #1e3a5f;
    }

    /* ============ BADGES ============ */
    .badge {
        display: inline-block;
        padding: 3px 11px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 0.2px;
    }

    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-info { background: #e0e7ff; color: #3730a3; }

    /* ============ PARAGRAPHES ============ */
    .paragraph {
        font-size: 12.5px;
        text-align: justify;
        margin: 14px 0;
        color: #2b3444;
    }

    /* ============ SIGNATURES ============ */
    .signature-box {
        margin-top: 46px;
        width: 100%;
        border-collapse: collapse;
    }

    .signature-box td {
        width: 50%;
        text-align: center;
        font-size: 10.5px;
        vertical-align: top;
        padding: 0 20px;
        color: #4b5568;
    }

    .signature-line {
        margin-top: 48px;
        border-top: 1.5px solid #1e3a5f;
        padding-top: 5px;
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        font-weight: bold;
        text-transform: uppercase;
        color: #1f2937;
        letter-spacing: 0.3px;
    }

    /* ============ ENCADRE DE DECISION / MENTION ============ */
    .summary-box {
        background: #f7f8fa;
        border: 1px solid #1e3a5f;
        border-radius: 4px;
        padding: 16px 20px;
        margin-top: 18px;
    }

    .summary-box .value {
        font-family: 'DejaVu Serif', serif;
        font-size: 24px;
        font-weight: bold;
        color: #1e3a5f;
        letter-spacing: 0.4px;
    }

    .summary-box .label {
        font-size: 9.5px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-top: 4px;
    }
</style>