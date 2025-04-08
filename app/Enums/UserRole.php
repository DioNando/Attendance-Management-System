<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case ORGANIZER = 'organizer';
    case STAFF = 'staff';
    case SCANNER = 'scanner';
    case GUEST = 'guest';

    public static function all(): array
    {
        return [
            self::ADMIN,
            self::ORGANIZER,
            self::STAFF,
            self::SCANNER,
            self::GUEST
        ];
    }

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrateur',
            self::ORGANIZER => 'Organisateur',
            self::STAFF => 'Staff',
            self::SCANNER => 'Scanner',
            self::GUEST => 'Invité',
        };
    }
}
