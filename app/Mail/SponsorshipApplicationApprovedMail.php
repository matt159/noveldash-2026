<?php

namespace App\Mail;

use App\Models\SponsorshipApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SponsorshipApplicationApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public SponsorshipApplication $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Sponsored Place Application — '.config('submission.title'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.sponsorship-application-approved',
        );
    }
}
