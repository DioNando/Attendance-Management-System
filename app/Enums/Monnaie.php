<?php

namespace App\Enums;

enum Monnaie: string
{
    case MAD = 'mad';
    case EUR = 'eur';
    case USD = 'usd';
    case AUTRE = 'autre';

    public static function all(): array
    {
        return [
            self::MAD,
            self::EUR,
            self::USD,
            self::AUTRE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::MAD => 'MAD',
            self::EUR => 'EUR', 
            self::USD => 'USD',
            self::AUTRE => 'Autre',
        };
    }
}
