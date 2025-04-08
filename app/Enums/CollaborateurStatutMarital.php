<?php

namespace App\Enums;

enum CollaborateurStatutMarital: string
{
    case CELIBATAIRE = 'celibataire';
    case MARIE = 'marie';
    case DIVORCE = 'divorce';
    case VEUF = 'veuf';

    public static function all(): array
    {
        return [
            self::CELIBATAIRE,
            self::MARIE,
            self::DIVORCE,
            self::VEUF,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::CELIBATAIRE => 'Célibataire',
            self::MARIE => 'Marié(e)',
            self::DIVORCE => 'Divorcé(e)',
            self::VEUF => 'Veuf(ve)',
        };
    }
}
