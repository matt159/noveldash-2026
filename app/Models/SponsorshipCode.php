<?php

namespace App\Models;

use Database\Factories\SponsorshipCodeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorshipCode extends Model
{
    /** @use HasFactory<SponsorshipCodeFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'entry_id',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    public function isUsed(): bool
    {
        return $this->entry_id !== null;
    }
}
