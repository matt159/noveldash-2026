<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Models\Concerns\RecordsRevisions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SponsoredPlace extends Model
{
    use RecordsRevisions;

    protected $fillable = [
        'name',
        'email',
        'twitter_handle',
        'publish_details',
        'stripe_session_id',
        'payment_status',
    ];

    protected function casts(): array
    {
        return [
            'publish_details' => 'boolean',
            'payment_status' => PaymentStatus::class,
        ];
    }

    public function sponsorshipCode(): HasOne
    {
        return $this->hasOne(SponsorshipCode::class);
    }
}
