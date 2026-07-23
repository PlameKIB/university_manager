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
        height: 70px;
        text-align: center;
        border-bottom: 2px solid #4f46e5;
        padding-bottom: 8px;
    }

    .header .institution {
        font-size: 16px;
        font-weight: bold;
        color: #1f2937;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .header .sub {
        font-size: 10px;
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
        color: #1f2937;
    }

    .doc-subtitle {
        text-align: center;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 22px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .info-table td {
        padding: 5px 8px;
        font-size: 12px;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-table td.label {
        width: 38%;
        color: #6b7280;
        font-weight: bold;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    .data-table th {
        background: #eef2ff;
        color: #4338ca;
        font-size: 10px;
        text-transform: uppercase;
        padding: 8px 6px;
        text-align: left;
        border-bottom: 2px solid #c7d2fe;
    }

    .data-table td {
        padding: 7px 6px;
        font-size: 11px;
        border-bottom: 1px solid #f3f4f6;
    }

    .data-table tr:nth-child(even) {
        background: #fafafa;
    }

    .text-right { text-align: right; }
    .text-center { text-align: center; }

    .badge {
        display: inline-block;
        padding: 2px 10px;
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
        margin-top: 50px;
        width: 100%;
    }

    .signature-box td {
        width: 50%;
        text-align: center;
        font-size: 11px;
        vertical-align: top;
    }

    .signature-line {
        margin-top: 45px;
        border-top: 1px solid #9ca3af;
        padding-top: 4px;
        width: 70%;
        margin-left: auto;
        margin-right: auto;
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
