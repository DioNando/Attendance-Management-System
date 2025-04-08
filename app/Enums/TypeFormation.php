<?php

namespace App\Enums;

enum TypeFormation: string
{
    case INTERNE = 'interne';
    case EXTERNE = 'externe';
    case EN_LIGNE = 'en_ligne';

    public static function all(): array
    {
        return [
            self::INTERNE,
            self::EXTERNE,
            self::EN_LIGNE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::INTERNE => 'Interne',
            self::EXTERNE => 'Externe',
            self::EN_LIGNE => 'En ligne',
        };
    }
}
