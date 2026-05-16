<?php

namespace App\Enums;

enum ConversionTypes: string
{
    case ErrorReport = 'error_report';
    case FeatureRequest = 'feature_request';

    public function label() : string 
    {
        return match ($this) {
            self::ErrorReport => 'Error Report',
            self::FeatureRequest => 'Feature Request'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
