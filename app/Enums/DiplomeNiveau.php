<?php

namespace App\Enums;

enum DiplomeNiveau: string
{
    case BAC = 'bac';
    case BTS = 'bts';
    case LICENCE = 'licence';
    case MASTER = 'master';
    case DOCTORAT = 'doctorat';
    case AUTRE = 'autre';

    public static function all(): array
    {
        return [
            self::BAC,
            self::BTS,
            self::LICENCE,
            self::MASTER,
            self::DOCTORAT,
            self::AUTRE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::BAC => 'Bac',
            self::BTS => 'BTS',
            self::LICENCE => 'Licence',
            self::MASTER => 'Master',
            self::DOCTORAT => 'Doctorat',
            self::AUTRE => 'Autre',
        };
    }
}
