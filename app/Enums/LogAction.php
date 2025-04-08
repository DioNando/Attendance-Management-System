<?php

namespace App\Enums;

enum LogAction: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case LOGIN = 'login';
    case LOGOUT = 'logout';
    case VIEW = 'view';
    case EXPORT = 'export';
    case OTHER = 'other';

    public static function all(): array
    {
        return [
            self::CREATE,
            self::UPDATE,
            self::DELETE,
            self::LOGIN,
            self::LOGOUT,
            self::VIEW,
            self::EXPORT,
            self::OTHER,
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::CREATE => 'Création',
            self::UPDATE => 'Mise à jour',
            self::DELETE => 'Suppression',
            self::LOGIN => 'Connexion',
            self::LOGOUT => 'Déconnexion',
            self::VIEW => 'Consultation',
            self::EXPORT => 'Exportation',
            self::OTHER => 'Autre',
        };
    }
}
