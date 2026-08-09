<style>
    @page {
        margin: 90px 50px 110px 50px;
    }

    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 12px;
        color: #1f2937;
        line-height: 1.5;
    }

    .header {
        position: fixed;
        top: -80px;
        left: 0;
        right: 0;
        height: 92px;
        text-align: center;
        border-bottom: 2px solid #4f46e5;
        padding-bottom: 10px;
        background: transparent;
    }

    .flag-bar {
        display: flex;
        height: 5px;
        margin-bottom: 8px;
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

    .header-row {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .header .app-logo {
        width: 150px;
        height: 90px;
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
        font-size: 10px;
        font-weight: bold;
        color: #111827;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .header .ministry {
        font-size: 8px;
        color: #6b7280;
        text-transform: uppercase;
        margin-top: 1px;
    }

    .header .institution {
        font-size: 15px;
        font-weight: bold;
        color: #1f2937;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 3px;
    }

    .header .sub {
        font-size: 9px;
        color: #6b7280;
        margin-top: 2px;
    }

    .footer {
        position: fixed;
        bottom: -95px;
        left: 0;
        right: 0;
        height: 90px;
        border-top: 1px solid #d1d5db;
        padding-top: 10px;
        font-size: 9px;
        color: #6b7280;
    }

    .footer table {
        width: 100%;
    }

    .footer .qr-cell {
        width: 60px;
        text-align: left;
        vertical-align: middle;
    }

    .footer .qr-cell img {
        width: 55px;
        height: 55px;
    }

    .footer .text-cell {
        vertical-align: middle;
        padding-left: 10px;
    }

    .footer .code {
        font-weight: bold;
        color: #4f46e5;
        font-size: 11px;
    }

    .doc-title {
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 10px 0 4px 0;
        color: #111827;
        border-top: 2px solid #111827;
        border-bottom: 2px solid #111827;
        padding: 8px 0;
    }

    .doc-subtitle {
        text-align: center;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 18px;
        font-weight: bold;
    }

    .identity-table {
        margin-bottom: 18px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .info-table td {
        padding: 6px 8px;
        font-size: 12px;
        border-bottom: 1px solid #e5e7eb;
    }

    .info-table td.label {
        width: 38%;
        color: #374151;
        font-weight: bold;
        background: #f9fafb;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .data-table th {
        background: #1f3a5f;
        color: #ffffff;
        font-size: 10px;
        text-transform: uppercase;
        padding: 8px 6px;
        text-align: left;
    }

    .data-table td {
        padding: 7px 6px;
        font-size: 11px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    .data-table tbody tr:nth-child(even) {
        background: #f8fafc;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .summary-grid {
        display: table;
        width: 100%;
        margin: 18px 0 18px;
        border-collapse: collapse;
    }

    .summary-card {
        display: table-cell;
        width: 25%;
        padding: 10px;
        background: #f8fafc;
        text-align: center;
    }

    .summary-label {
        color: #6b7280;
        text-transform: uppercase;
        font-size: 9px;
        margin-bottom: 5px;
    }

    .summary-value {
        font-size: 13px;
        font-weight: bold;
        color: #111827;
    }

    .badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 10px;
        font-size: 10px;
        font-weight: bold;
    }

    .badge-success { background: #d1fae5; color: #065f46; }
    .badge-danger { background: #fee2e2; color: #991b1b; }
    .badge-info { background: #e0e7ff; color: #3730a3; }

    .paragraph {
        font-size: 12.5px;
        text-align: justify;
        margin: 14px 0;
    }

    .signature-box {
        margin-top: 40px;
        width: 100%;
        border-collapse: collapse;
    }

    .signature-box td {
        width: 50%;
        text-align: center;
        font-size: 11px;
        vertical-align: top;
        padding: 0 16px;
    }

    .signature-line {
        margin-top: 45px;
        border-top: 2px solid #111827;
        padding-top: 4px;
        width: 78%;
        margin-left: auto;
        margin-right: auto;
        font-weight: bold;
        text-transform: uppercase;
    }

    .summary-box {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        padding: 14px 18px;
        margin-top: 16px;
    }

    .summary-box .value {
        font-size: 22px;
        font-weight: bold;
        color: #4f46e5;
    }

    .summary-box .label {
        font-size: 10px;
        color: #6b7280;
        text-transform: uppercase;
    }
</style>
