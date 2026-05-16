<?php

namespace App\Enums;

enum RequestType: string
{
    case FeatureRequest = 'feature_request';
    case BugFix = 'bug_fix';

    public function label(): string
    {
        return match ($this) {
            self::FeatureRequest => 'Feature Request',
            self::BugFix => 'Bug Fix'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
