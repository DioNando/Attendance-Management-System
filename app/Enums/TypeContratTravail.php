<?php

namespace App\Enums;

enum TypeContratTravail: string
{
    case CDI = 'cdi';
    case CDD = 'cdd';
    case ANAPEC = 'anapec';
    case STAGE = 'stage';
    case FREELANCE = 'freelance';
    case AUTRE = 'autre';

    public static function all(): array
    {
        return [
            self::CDI,
            self::CDD,
            self::ANAPEC,
            self::STAGE,
            self::FREELANCE,
            self::AUTRE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::CDI => 'CDI',
            self::CDD => 'CDD',
            self::ANAPEC => 'Anapec',
            self::STAGE => 'Stage',
            self::FREELANCE => 'Freelance',
            self::AUTRE => 'Autre',
        };
    }
}
