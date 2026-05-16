<?php

namespace App\Enums;

enum Priorities: string
{
    case Low = 'low';
    case Medium = 'Medium';
    case High = 'High';
    case Critical = 'critical';

    public function label(): string
    {
        return match ($this) {
            self::Low => 'Low Priority',
            self::Medium => 'Medium Priority',
            self::High => 'High Priority',
            self::Critical => 'Critical Priority',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
