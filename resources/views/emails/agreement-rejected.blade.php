<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Agreement — Action Required</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 15px; color: #222; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 32px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,.08); }
        .header { background: #1a1a2e; color: #fff; padding: 28px 32px; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 700; }
        .header p { margin: 6px 0 0; font-size: 13px; color: #aaa; }
        .body { padding: 28px 32px; }
        .body p { margin: 0 0 14px; line-height: 1.6; }
        .reason-box { background: #fff8f0; border-left: 4px solid #f59e0b; border-radius: 4px; padding: 14px 18px; margin: 20px 0; }
        .reason-box p { margin: 0; font-size: 14px; line-height: 1.6; }
        .footer { padding: 16px 32px; background: #f5f5f5; font-size: 12px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Faisal Car Rentals Perth</h1>
        <p>Rental Agreement — Action Required</p>
    </div>
    <div class="body">
        <p>Dear {{ $agreement->driver_name }},</p>
        <p>Unfortunately, your rental agreement submission (<strong>{{ $agreement->agreement_number }}</strong>) could not be approved at this time.</p>

        @if ($agreement->rejection_note)
            <p><strong>Reason from admin:</strong></p>
            <div class="reason-box">
                <p>{{ $agreement->rejection_note }}</p>
            </div>
        @endif

        <p>Please visit our agreement portal, correct the issue noted above, and resubmit your agreement. You are free to submit a new agreement at any time.</p>

        <p>If you have questions, please contact Faisal directly on <strong>0424 022 786</strong>.</p>

        <p>Regards,<br><strong>Faisal Car Rentals Perth</strong><br>0424 022 786<br>58 Royal Street, Tuart Hill, Perth WA</p>
    </div>
    <div class="footer">
        This is an automated message. Please do not reply to this email.
    </div>
</div>
</body>
</html>
