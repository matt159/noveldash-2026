<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SponsoredPlace extends Model
{
    protected $fillable = [
        'name',
        'email',
        'twitter_handle',
        'publish_details',
    ];

    protected function casts(): array
    {
        return [
            'publish_details' => 'boolean',
        ];
    }
}
