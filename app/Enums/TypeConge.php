<?php

namespace App\Enums;

enum TypeConge: string
{
    case ANNUEL = 'annuel';
    case MALADIE = 'maladie';
    case MATERNITE = 'maternite';
    case PATERNITE = 'paternite';
    case SANS_SOLDE = 'sans_solde';
    case AUTRE = 'autre';

    public static function all(): array
    {
        return [
            self::ANNUEL,
            self::MALADIE,
            self::MATERNITE,
            self::PATERNITE,
            self::SANS_SOLDE,
            self::AUTRE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::ANNUEL => 'Congé annuel',
            self::MALADIE => 'Congé maladie',
            self::MATERNITE => 'Congé maternité',
            self::PATERNITE => 'Congé paternité',
            self::SANS_SOLDE => 'Congé sans solde',
            self::AUTRE => 'Autre type de congé',
        };
    }
}
