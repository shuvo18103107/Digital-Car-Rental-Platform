<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental Agreement — {{ $agreement->agreement_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 15px; color: #222; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .header { background: #1a1a2e; color: #fff; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 700; }
        .header p { margin: 6px 0 0; font-size: 13px; color: #aaa; }
        .body { padding: 28px 32px; }
        .body p { margin: 0 0 14px; line-height: 1.6; }
        .details { background: #f9f9f9; border-radius: 6px; padding: 16px 20px; margin: 20px 0; }
        .details table { width: 100%; border-collapse: collapse; }
        .details td { padding: 5px 0; font-size: 14px; }
        .details td:first-child { color: #666; width: 48%; }
        .details td:last-child { font-weight: 600; }
        .footer { padding: 16px 32px; background: #f5f5f5; font-size: 12px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Faisal Car Rentals Perth</h1>
        <p>Car Rental Agreement — {{ $agreement->agreement_number }}</p>
    </div>
    <div class="body">
        @if ($recipientType === 'driver')
            <p>Dear {{ $agreement->driver_name }},</p>
            <p>Your car rental agreement has been <strong>approved</strong>. Please find your signed agreement attached to this email as a PDF. Keep it for your records.</p>
        @elseif ($recipientType === 'owner')
            <p>Hi Faisal,</p>
            <p>A new rental agreement has been approved. The signed PDF is attached below.</p>
        @else
            <p>Hi,</p>
            <p>A new rental agreement has been approved. The signed PDF is attached for your records.</p>
        @endif

        <div class="details">
            <table>
                <tr>
                    <td>Agreement Number</td>
                    <td>{{ $agreement->agreement_number }}</td>
                </tr>
                <tr>
                    <td>Driver Name</td>
                    <td>{{ $agreement->driver_name }}</td>
                </tr>
                <tr>
                    <td>Vehicle</td>
                    <td>{{ $agreement->car_make_model }}</td>
                </tr>
                <tr>
                    <td>Plate Number</td>
                    <td>{{ $agreement->plate_number }}</td>
                </tr>
                <tr>
                    <td>Weekly Rent</td>
                    <td>AUD ${{ number_format($agreement->weekly_rent, 2) }}</td>
                </tr>
                <tr>
                    <td>Pickup Date</td>
                    <td>{{ $agreement->pickup_date->format('d M Y') }}</td>
                </tr>
                <tr>
                    <td>Approved</td>
                    <td>{{ $agreement->approved_at?->format('d M Y, h:i A') ?? now()->format('d M Y, h:i A') }}</td>
                </tr>
            </table>
        </div>

        @if ($recipientType === 'driver')
            <p>If you have any questions, please contact Faisal directly on <strong>0424 022 786</strong>.</p>
        @endif

        <p>Regards,<br><strong>Faisal Car Rentals Perth</strong><br>0424 022 786<br>58 Royal Street, Tuart Hill, Perth WA</p>
    </div>
    <div class="footer">
        This is an automated message. Please do not reply to this email.
    </div>
</div>
</body>
</html>
