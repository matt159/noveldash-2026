<?php

namespace App\Models;

use App\Enums\EntryRound;
use App\Enums\EntryRoundStatus;
use App\Enums\PaymentStatus;
use Database\Factories\EntryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entry extends Model
{
    /** @use HasFactory<EntryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'manuscript_path',
        'sponsorship_code_id',
        'stripe_session_id',
        'stripe_payment_intent_id',
        'payment_status',
        'current_round',
        'round_status',
        'feedback_path',
        'feedback_token',
        'feedback_sent_at',
        'manually_confirmed_at',
        'manually_confirmed_by',
    ];

    protected $casts = [
        'payment_status' => PaymentStatus::class,
        'current_round' => EntryRound::class,
        'round_status' => EntryRoundStatus::class,
        'feedback_sent_at' => 'datetime',
        'manually_confirmed_at' => 'datetime',
    ];

    public function sponsorshipCode(): BelongsTo
    {
        return $this->belongsTo(SponsorshipCode::class);
    }

    public function isPaid(): bool
    {
        return in_array($this->payment_status, [PaymentStatus::Completed, PaymentStatus::Sponsored]);
    }

    public function isManuallyConfirmed(): bool
    {
        return $this->manually_confirmed_at !== null;
    }

    public function hasFeedback(): bool
    {
        return $this->feedback_path !== null;
    }

    public function feedbackWasSent(): bool
    {
        return $this->feedback_sent_at !== null;
    }

    /**
     * Returns the status of this entry for the given round page.
     * Entries appear on a round page if they have reached that round or higher.
     */
    public function statusForRound(EntryRound $round): ?EntryRoundStatus
    {
        if ($this->current_round === null) {
            return null;
        }

        $order = [EntryRound::Round1, EntryRound::Top100, EntryRound::Longlist, EntryRound::Shortlist];
        $currentIndex = array_search($this->current_round, $order);
        $roundIndex = array_search($round, $order);

        if ($currentIndex > $roundIndex) {
            return EntryRoundStatus::Passed;
        }

        if ($currentIndex === $roundIndex) {
            return $this->round_status;
        }

        return null;
    }
}
