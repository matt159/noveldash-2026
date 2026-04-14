<?php

namespace App\Models;

use App\Enums\SponsorshipApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorshipApplication extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'reason',
        'supporting_document_path',
        'status',
        'sponsorship_code_id',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'status' => SponsorshipApplicationStatus::class,
        'reviewed_at' => 'datetime',
    ];

    public function sponsorshipCode(): BelongsTo
    {
        return $this->belongsTo(SponsorshipCode::class);
    }

    public function isPending(): bool
    {
        return $this->status === SponsorshipApplicationStatus::Pending;
    }
}
