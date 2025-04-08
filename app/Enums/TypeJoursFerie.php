<?php

namespace App\Enums;

enum TypeJoursFerie: string
{
    case NATIONAL = 'national';
    case RELIGIEUX = 'religieux';

    public static function all(): array
    {
        return [
            self::NATIONAL,
            self::RELIGIEUX,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::NATIONAL => 'National',
            self::RELIGIEUX => 'Religieux',
        };
    }
}
