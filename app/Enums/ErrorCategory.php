<?php

namespace App\Enums;

enum ErrorCategory: string
{
    case Hardware = 'hardware';
    case Software = 'software';
    case Network = 'network';

    public function label(): string
    {
        return match ($this) {
            self::Hardware => 'Hardware Error',
            self::Software => 'Software Error',
            self::Network => 'Network Error',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
