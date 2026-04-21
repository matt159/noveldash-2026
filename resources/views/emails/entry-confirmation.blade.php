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

        <p style="font-size: 15px; margin: 0 0 16px; color: #374151;">Dear {{ $entry->name }},</p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 16px;">
            Thank you for entering <strong>{{ config('submission.title') }}</strong>. We cannot wait to read your work.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            Your entry ID is <strong>{{ $entry->uid }}</strong>. Please keep this for your records.
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Important Dates</strong></span>
            Entries opened: {{ \Carbon\Carbon::parse(config('dates.prize_opening_date'))->format('jS F Y') }}.<br/>
            <!-- Our judges will be announced on the {{ config('dates.judges_announcement_date_text') }}.<br/> -->
            Entries close: {{ \Carbon\Carbon::parse(config('dates.prize_closing_date'))->format('jS F Y') }}.<br/>
            Longlist announced: {{ config('dates.longlist_announcement_date_text') }}<br/>
            Top 100 announced: {{ config('dates.top_100_announcement_date_text') }}.<br/>
            Shortlist announced: {{ config('dates.shortlist_announcement_date_text') }}<br/>
            Winner announced: {{ config('dates.winner_announcement_date_text') }}
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Sponsored places</strong></span>
            <span style="display:block; margin-bottom: 12px;">We know times are tough, but unfortunately the general rise in the cost of living doesn’t qualify for a sponsored entry.</span>
            <span style="display:block; margin-bottom: 12px;">Each year, we offer over 300 sponsored places for writers who meet our criteria, helping under-represented voices enter free of charge. Around 1% of these places are funded by writers themselves, with the remainder supported personally by Sara Naidine Cox and through our summer school courses.</span>
            <span style="display:block; margin-bottom: 12px;">To check if you’re eligible, please visit the criteria on our website: <a href="https://www.cheshirenovelprize.com" target="_blank">www.cheshirenovelprize.com</a></span>
            <span style="display:block; margin-bottom: 12px;">The sponsored entry portal closes at <strong>{{ config('dates.sponsored_entry_closing_date_text') }}</strong>. Applications submitted after this time won’t be considered, so please make sure you apply well in advance.</span>
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 20px;">
            <span style="display:block; margin-bottom: 12px;"><strong>Feedback</strong></span>
            <span style="display:block; margin-bottom: 12px;">Every entry receives at least one paragraph of personalised feedback at no extra cost, along with clearly labelled generic feedback. Your entry fee is for entering the competition.</span>
            <span style="display:block; margin-bottom: 12px;">Feedback is sent out after the winner is announced in <strong>{{ config('dates.winner_announcement_date_text') }}</strong>, and will continue to be distributed until <strong>{{ config('dates.feedback_cutoff_date_text') }}</strong>. We aim to send it as soon as possible, but due to the volume of entries and the care taken with each response, it can take up to 62 days.</span>
            <span style="display:block; margin-bottom: 12px;">All feedback is written by hand—no automated systems—so we really appreciate your patience. Please don’t email us to ask about feedback before the winner has been announced; we promise it’s on its way.</span>
            <span style="display:block; margin-bottom: 12px;">If you haven’t received your feedback by 28th February 2027:</span>
        </p>
        <ul style="font-size: 15px; display:block; margin-bottom: 32px; color: #374151;">
            <li>First, please check your junk folder it often ends up there</li>
            <li>If it’s not there, email us with the name of your novel</li>
        </ul>

        <p style="font-size: 15px; color: #374151; margin: 0 0 20px;">
            <span style="display:block; margin-bottom: 12px; text-decoration: underline;"><strong>Please note</strong></span>
        </p>
        <ul style="font-size: 15px; display:block; margin-bottom: 50px; color: #374151;">
            <li>The dashboard is cleared on {{ config('dates.dashboard_cleared_date_text') }}</li>
            <li>After this date, we won’t be able to retrieve your feedback</li>
            <li>All entries are deleted in line with GDPR to ensure we don’t store your data longer than necessary</li>
        </ul>


        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 24px;">Thank you so much for entering the prize. Wishing you the very best of luck, and thank you for trusting us with your work.</span>
            <span style="display:block; margin-bottom: 12px;">Kind regards,<br/>Sara Cox</span>
            <span style="display:block; margin-bottom: 12px;">Founder, Cheshire Novel Prize<br/><a href="https://www.cheshirenovelprize.com" target="_blank">www.cheshirenovelprize.com</a></span>
        </p>

        <p style="font-size: 15px; color: #374151; margin: 0 0 32px;">
            <span style="display:block; margin-bottom: 12px;">
                Have you listened to our Tortured Writers Podcast?<br/>
                <a href="https://podcasts.apple.com/gb/podcast/the-tortured-writers-podcast/id1850575482" target="_blank">https://podcasts.apple.com/gb/podcast/the-tortured-writers-podcast/id1850575482</a>
            </span>
            <span style="display:block; margin-bottom: 12px;">It’s also available wherever you get your podcasts, with a new season coming soon.</span>
        </p>



        <p style="font-size: 13px; color: #9ca3af; border-top: 1px solid #f3f4f6; padding-top: 24px; margin: 0;">
            {{ config('submission.title') }}
        </p>
    </div>
</body>
</html>
