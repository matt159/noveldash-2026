<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sponsored Place Approved</title>
</head>
<body style="font-family: sans-serif; color: #1a1a1a; background: #f9fafb; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 40px;">
        <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 8px;">{{ config('submission.title') }}</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 32px;">Sponsored place application</p>

        <p style="font-size: 15px; margin: 0 0 16px;">Dear {{ $application->name }},</p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            We are delighted to let you know that your application for a sponsored place in <strong>{{ config('submission.title') }}</strong> has been approved.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 8px;">
            Your sponsorship code is:
        </p>

        <div style="background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 8px; padding: 16px 24px; margin: 0 0 24px; text-align: center;">
            <span style="font-family: monospace; font-size: 22px; font-weight: 700; letter-spacing: 0.1em; color: #111827;">{{ $application->sponsorshipCode->code }}</span>
        </div>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            Please use this code when completing your entry. <strong>You must enter within 48 hours</strong> or your sponsored place may be cancelled.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            Good luck with your submission!
        </p>

        <p style="font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 24px; margin: 0;">
            If you have any questions, please do not reply to this email.<br>
            {{ config('submission.title') }}
        </p>
    </div>
</body>
</html>
