<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Thank you for entering</title>
</head>
<body style="font-family: sans-serif; color: #1a1a1a; background: #f9fafb; margin: 0; padding: 40px 20px;">
    <div style="max-width: 560px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 40px;">
        <h1 style="font-size: 22px; font-weight: 700; margin: 0 0 8px;">{{ config('submission.title') }}</h1>
        <p style="font-size: 14px; color: #6b7280; margin: 0 0 32px;">Entry confirmation</p>

        <p style="font-size: 15px; margin: 0 0 16px;">Dear {{ $entry->name }},</p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            Thank you for entering <strong>{{ config('submission.title') }}</strong>. We cannot wait to read your work.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            Your entry ID is <strong>{{ $entry->uid }}</strong>. Please keep this for your records.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Important Dates</strong></span>
            Our prize opened for entries on {{ \Carbon\Carbon::parse(config('dates.prize_opening_date'))->format('jS F Y') }}.<br/>
            Our judges will be announced on the {{ config('dates.judges_announcement_date_text') }}.<br/>
            Our prize closes for entries on {{ \Carbon\Carbon::parse(config('dates.prize_closing_date'))->format('jS F Y') }}.<br/>
            Our longlist is announced in {{ config('dates.longlist_announcement_date_text') }}<br/>
            Our Top 100 will be announced shortly after the longlist in {{ config('dates.top_100_announcement_date_text') }}.<br/>
            Our shortlist is announced in {{ config('dates.shortlist_announcement_date_text') }}<br/>
            Our winner announcement will be in {{ config('dates.winner_announcement_date_text') }}
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Sponsored places</strong></span>
            <span style="display:block; margin-bottom: 12px;">We realise that the world has gone slightly mad at the moment, but the higher cost of living unfortunately does not qualify for a sponsored entry.</span>
            <span style="display:block; margin-bottom: 12px;">In order to check the eligibility of our sponsorship places, please check our criteria on our home page on our website.</span>
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Feedback</strong></span>
            <span style="display:block; margin-bottom: 12px;">We offer at least one paragraph of feedback free of charge for every entry as an addition. Your entry fee is to enter the competition.</span>
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px; text-decoration: underline;"><strong>Please note</strong></span>
            <span style="display:block; margin-bottom: 12px;"><strong>Feedback never goes out until after the winner is announced which is {{ config('dates.winner_announcement_date_text') }}. Feedback will go out until {{ config('dates.feedback_cutoff_date_text') }}. However, we will try to get this out as soon as possible.</strong></span>
            <span style="display:block; margin-bottom: 12px;"><strong>Because of the high level of entries, we take up to 62 days to send out feedback.</strong></span>
        </p>


        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;">All of our feedback is written by hand, and we do not use computerised systems to do this. Please bear with us and please do not email us asking where it is if the winner has not been announced.</span>
            <span style="display:block; margin-bottom: 12px;">Anyone sending abusive or unkind messages to the CNP team will automatically be disqualified from receiving feedback and f before the longlist announcements disqualified from the competition.</span>
        </p>



        <p style="font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 24px; margin: 0;">
            {{ config('submission.title') }}
        </p>
    </div>
</body>
</html>
