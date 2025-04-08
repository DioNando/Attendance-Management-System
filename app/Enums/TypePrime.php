<?php

namespace App\Enums;

enum TypePrime: string
{
    case PERFORMANCE = 'performance';
    case ANNIVERSAIRE = 'anniversaire';
    case EXCEPTIONNELLE = 'exceptionnelle';
    case AUTRE = 'autre';

    public static function all(): array
    {
        return [
            self::PERFORMANCE,
            self::ANNIVERSAIRE,
            self::EXCEPTIONNELLE,
            self::AUTRE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::PERFORMANCE => 'Performance',
            self::ANNIVERSAIRE => 'Anniversaire',
            self::EXCEPTIONNELLE => 'Exceptionnelle',
            self::AUTRE => 'Autre',
        };
    }
}
