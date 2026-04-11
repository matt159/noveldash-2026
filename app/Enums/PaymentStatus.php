<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Sponsored = 'sponsored';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Payment',
            self::Completed => 'Paid',
            self::Sponsored => 'Sponsored',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-yellow-100 text-yellow-800',
            self::Completed => 'bg-green-100 text-green-800',
            self::Sponsored => 'bg-purple-100 text-purple-800',
        };
    }
}
