<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Car Rental Agreement — {{ $agreement->agreement_number }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 10pt;
        color: #111;
        line-height: 1.5;
    }

    .page {
        padding: 28px 36px;
    }

    /* ── Header ── */
    .header {
        border-bottom: 2px solid #1e3a5f;
        padding-bottom: 10px;
        margin-bottom: 16px;
    }
    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .company-name {
        font-size: 15pt;
        font-weight: bold;
        color: #1e3a5f;
    }
    .agreement-id {
        text-align: right;
        font-size: 8.5pt;
        color: #555;
    }
    .agreement-id strong {
        font-size: 10pt;
        color: #111;
    }
    .doc-title {
        font-size: 13pt;
        font-weight: bold;
        color: #1e3a5f;
        margin-top: 4px;
    }

    /* ── Section headings ── */
    .section-title {
        font-size: 9pt;
        font-weight: bold;
        color: #fff;
        background-color: #1e3a5f;
        padding: 4px 8px;
        margin-top: 14px;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ── Field grid (two-column) ── */
    table.fields {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 4px;
    }
    table.fields td {
        padding: 3px 6px;
        font-size: 9.5pt;
        vertical-align: top;
        border: 1px solid #e2e2e2;
    }
    table.fields td.label {
        width: 38%;
        color: #555;
        font-weight: bold;
        background-color: #f7f7f7;
    }
    table.fields td.value {
        color: #111;
    }
    table.fields td.value.highlight {
        font-weight: bold;
        color: #1e3a5f;
    }

    /* ── Agreement body (Part A) ── */
    .agreement-body {
        font-size: 8.5pt;
        line-height: 1.55;
        color: #222;
    }
    .agreement-body h2 {
        font-size: 11pt;
        font-weight: bold;
        color: #1e3a5f;
        margin: 12px 0 4px;
    }
    .agreement-body h3 {
        font-size: 9.5pt;
        font-weight: bold;
        color: #1e3a5f;
        margin: 10px 0 3px;
        border-bottom: 1px solid #ddd;
        padding-bottom: 2px;
    }
    .agreement-body p {
        margin-bottom: 4px;
    }
    .agreement-body ul, .agreement-body ol {
        margin: 3px 0 6px 16px;
    }
    .agreement-body li {
        margin-bottom: 2px;
    }
    .agreement-body strong {
        font-weight: bold;
    }

    /* ── Owner block ── */
    .owner-block {
        border: 1px solid #ccc;
        padding: 8px 10px;
        margin-top: 6px;
        background-color: #f9f9f9;
        font-size: 9pt;
    }
    .owner-block .owner-label {
        font-weight: bold;
        color: #555;
        width: 90px;
        display: inline-block;
    }

    /* ── Signature block ── */
    .signature-block {
        margin-top: 12px;
        border: 1px solid #ccc;
        padding: 10px;
    }
    .signature-block table {
        width: 100%;
        border-collapse: collapse;
    }
    .signature-block td {
        vertical-align: bottom;
        padding: 4px 8px;
        font-size: 9pt;
    }
    .signature-block img {
        max-height: 70px;
        max-width: 240px;
        display: block;
    }
    .sig-line {
        border-top: 1px solid #555;
        margin-top: 6px;
        padding-top: 3px;
        font-size: 8pt;
        color: #555;
    }

    /* ── Footer ── */
    .footer {
        margin-top: 18px;
        border-top: 1px solid #ccc;
        padding-top: 6px;
        font-size: 7.5pt;
        color: #888;
        text-align: center;
    }
</style>
</head>
<body>
<div class="page">

    {{-- ── HEADER ── --}}
    <div class="header">
        <div class="header-top">
            <div>
                <div class="company-name">Faisal Car Rentals Perth</div>
                <div class="doc-title">Car Rental Agreement</div>
            </div>
            <div class="agreement-id">
                Agreement No.<br>
                <strong>{{ $agreement->agreement_number }}</strong><br>
                Date Approved: {{ $agreement->approved_at?->format('d M Y') ?? now()->format('d M Y') }}
            </div>
        </div>
    </div>

    {{-- ── PART B — Owner details (hardcoded, never changes) ── --}}
    <div class="section-title">Owner Information</div>
    <div class="owner-block">
        <span class="owner-label">Owner:</span> Faisal Rasheed<br>
        <span class="owner-label">Address:</span> 58 Royal Street, Tuart Hill, Perth WA<br>
        <span class="owner-label">Phone:</span> 0424 022 786<br>
        <span class="owner-label">Insurance:</span> Commercial Comprehensive — AUD $2,000 excess per incident
    </div>

    {{-- ── PART C — Vehicle & Agreement Details ── --}}
    <div class="section-title">Vehicle &amp; Agreement Details</div>
    <table class="fields">
        <tr>
            <td class="label">Car Make &amp; Model</td>
            <td class="value highlight">{{ $agreement->car_make_model }}</td>
            <td class="label">Plate Number</td>
            <td class="value highlight">{{ $agreement->plate_number }}</td>
        </tr>
        <tr>
            <td class="label">Bond Amount</td>
            <td class="value">AUD $500.00 (fixed)</td>
            <td class="label">Weekly Rent</td>
            <td class="value highlight">AUD ${{ number_format($agreement->weekly_rent, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Pickup Date</td>
            <td class="value">{{ $agreement->pickup_date->format('d M Y') }}</td>
            <td class="label">Pickup Time</td>
            <td class="value">{{ \Carbon\Carbon::parse($agreement->pickup_time)->format('h:i A') }}</td>
        </tr>
    </table>

    {{-- ── PART C — Driver / Renter Information ── --}}
    <div class="section-title">Driver / Renter Information</div>
    <table class="fields">
        <tr>
            <td class="label">Full Name</td>
            <td class="value" colspan="3">{{ $agreement->driver_name }}</td>
        </tr>
        <tr>
            <td class="label">Residential Address</td>
            <td class="value" colspan="3">{{ $agreement->renter_address }}</td>
        </tr>
        <tr>
            <td class="label">Licence Number</td>
            <td class="value">{{ $agreement->license_number }}</td>
            <td class="label">Contact Number</td>
            <td class="value">{{ $agreement->renter_contact }}</td>
        </tr>
        <tr>
            <td class="label">Email Address</td>
            <td class="value" colspan="3">{{ $agreement->driver_email }}</td>
        </tr>
        @if($agreement->towing_name || $agreement->towing_phone)
        <tr>
            <td class="label">Approved Mechanic</td>
            <td class="value">{{ $agreement->towing_name }}</td>
            <td class="label">Towing Phone</td>
            <td class="value">{{ $agreement->towing_phone }}</td>
        </tr>
        @endif
        @if($agreement->walkaround_comments)
        <tr>
            <td class="label">Walkaround Notes</td>
            <td class="value" colspan="3">{{ $agreement->walkaround_comments }}</td>
        </tr>
        @endif
    </table>

    {{-- ── PART A — Agreement body (frozen snapshot) ── --}}
    <div class="section-title">Terms &amp; Conditions</div>
    <div class="agreement-body">
        {!! $agreement->agreement_snapshot !!}
    </div>

    {{-- ── SIGNATURE BLOCK ── --}}
    <div class="signature-block">
        <table>
            <tr>
                <td style="width:55%">
                    <div style="font-size:8.5pt; font-weight:bold; color:#555; margin-bottom:4px;">Driver / Renter Signature</div>
                    @if($signatureBase64)
                        <img src="{{ $signatureBase64 }}" alt="Signature">
                    @else
                        <div style="height:60px; border:1px dashed #ccc;"></div>
                    @endif
                    <div class="sig-line">{{ $agreement->driver_name }}</div>
                </td>
                <td style="width:45%; padding-left:20px;">
                    <div style="font-size:8.5pt; font-weight:bold; color:#555; margin-bottom:4px;">Owner Signature</div>
                    @php
                        $ownerSigPath = storage_path('app/' . ($ownerSignaturePath ?? 'signatures/owner_signature.png'));
                    @endphp
                    @if(file_exists($ownerSigPath))
                        <img src="{{ $ownerSigPath }}"
                             style="height:45px; max-width:180px; object-fit:contain; display:block;">
                    @else
                        <div style="height:45px; border-bottom:1px solid #000; width:180px;"></div>
                    @endif
                    <div class="sig-line">Faisal Rasheed</div>
                </td>
            </tr>
        </table>
        <div style="margin-top:10px; font-size:8pt; color:#555;">
            <strong>Date Signed:</strong> {{ $agreement->approved_at?->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Agreement ID:</strong> {{ $agreement->agreement_number }}
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <strong>Governed by the laws of Western Australia.</strong>
        </div>
    </div>

    {{-- ── FOOTER ── --}}
    <div class="footer">
        Faisal Car Rentals Perth &nbsp;|&nbsp; 58 Royal Street, Tuart Hill, Perth WA &nbsp;|&nbsp; 0424 022 786
        &nbsp;|&nbsp; This document is legally binding once signed by both parties.
    </div>

</div>
</body>
</html>
