<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case RH = 'rh';
    case MANAGER = 'manager';
    case EMPLOYE = 'employe';

    public static function all(): array
    {
        return [
            self::ADMIN,
            self::USER,
            self::RH,
            self::MANAGER,
            self::EMPLOYE,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrateur',
            self::USER => 'Utilisateur',
            self::RH => 'Ressources Humaines',
            self::MANAGER => 'Manager',
            self::EMPLOYE => 'Employé',
        };
    }
}
