<?php

namespace App\Enums;

enum AssignedTeam: string
{
    case Programmer = 'programmer';
    case Network = 'network';
    case Hardware = 'hardware';

    public function label(): string
    {
        return match ($this) {
            self::Programmer => 'Programmer Team',
            self::Network => 'Network Team',
            self::Hardware => 'Hardware Team',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
