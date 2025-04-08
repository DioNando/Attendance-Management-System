<?php

namespace App\Enums;

enum CollaborateurGenre: string
{
    case HOMME = 'homme';
    case FEMME = 'femme';

    public static function all(): array
    {
        return [
            self::HOMME,
            self::FEMME,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::HOMME => 'Homme',
            self::FEMME => 'Femme',
        };
    }
}
