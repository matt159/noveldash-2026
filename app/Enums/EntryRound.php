<?php

namespace App\Enums;

enum EntryRound: string
{
    case Round1 = 'round1';
    case Top100 = 'top100';
    case Longlist = 'longlist';
    case Shortlist = 'shortlist';

    public function label(): string
    {
        return match ($this) {
            self::Round1 => 'Round 1',
            self::Top100 => 'Top 100',
            self::Longlist => 'Longlist',
            self::Shortlist => 'Shortlist',
        };
    }

    public function next(): ?self
    {
        return match ($this) {
            self::Round1 => self::Top100,
            self::Top100 => self::Longlist,
            self::Longlist => self::Shortlist,
            self::Shortlist => null,
        };
    }
}
