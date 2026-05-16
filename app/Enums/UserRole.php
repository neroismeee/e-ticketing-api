<?php

namespace App\Enums;

enum UserRole: string
{
    case Admin = 'admin';
    case TeamLead = 'team_lead';
    case ItStaff = 'it_staff';
    case Reporter = 'reporter';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::TeamLead => 'Team Lead',
            self::ItStaff => 'IT Staff',
            self::Reporter => 'Reporter',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
