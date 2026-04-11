<?php

namespace App\Enums;

enum EntryRoundStatus: string
{
    case Active = 'active';
    case Passed = 'passed';
    case Failed = 'failed';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active',
            self::Passed => 'Passed',
            self::Failed => 'Failed',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Active => 'bg-blue-100 text-blue-800',
            self::Passed => 'bg-green-100 text-green-800',
            self::Failed => 'bg-red-100 text-red-800',
        };
    }
}
