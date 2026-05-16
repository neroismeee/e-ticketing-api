<?php

namespace App\Enums;

enum DigestFreq: string
{
    case Immediate = 'immediate';
    case Hourly = 'hourly';
    case Daily = 'daily';
    case Weekly = 'weekly';

    public function label(): string
    {
        return match ($this) {
            self::Immediate => 'Immediate',
            self::Hourly => 'Hourly',
            self::Daily => 'Daily',
            self::Weekly => 'Weekly',
        };
    }  
    
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
