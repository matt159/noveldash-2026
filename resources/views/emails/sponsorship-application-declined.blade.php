<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sponsored Place Application</title>
</head>
<body style="font-family: sans-serif; color: #1a1a1a; background: #f9fafb; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 40px;">
        <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 8px;">{{ config('submission.title') }}</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 32px;">Sponsored place application</p>

        <p style="font-size: 15px; margin: 0 0 16px;">Dear {{ $application->name }},</p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            Thank you for applying for a sponsored place in <strong>{{ config('submission.title') }}</strong>.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            After careful consideration, we are unable to offer you a sponsored place at this time. We appreciate you taking the time to apply and wish you all the best.
        </p>

        <p style="font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 24px; margin: 0;">
            If you have any questions, please do not reply to this email.<br>
            {{ config('submission.title') }}
        </p>
    </div>
</body>
</html>
