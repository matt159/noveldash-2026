<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Your Feedback</title>
</head>
<body style="font-family: sans-serif; color: #1a1a1a; background: #f9fafb; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 40px;">
        <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 8px;">{{ config('submission.title') }}</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 32px;">Feedback on your submission</p>

        <p style="font-size: 15px; margin: 0 0 16px;">Dear {{ $entry->name }},</p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            Thank you for submitting to <strong>{{ config('submission.title') }}</strong>. We have reviewed your entry and have prepared feedback for you.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            Please click the button below to download your feedback. This link is unique to your entry.
        </p>

        <div style="text-align: center; margin: 0 0 32px;">
            <a href="{{ route('feedback.download', $entry->feedback_token) }}"
               style="display: inline-block; background: #111827; color: #ffffff; text-decoration: none; font-size: 14px; font-weight: 600; padding: 12px 28px; border-radius: 8px;">
                Download Feedback
            </a>
        </div>

        <p style="font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 24px; margin: 0;">
            If you have any questions, please do not reply to this email.<br>
            {{ config('submission.title') }}
        </p>
    </div>
</body>
</html>
