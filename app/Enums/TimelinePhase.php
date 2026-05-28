<?php

namespace App\Enums;

enum TimelinePhase: string
{
    case Submission = 'submission';
    case Approval = 'approval';
    case Assignment = 'assignment';
    case Development = 'development';
    case Testing = 'testing';
    case Validation = 'validation';
    case Completion = 'completion';
    case Review = 'review';

    public function label(): string
    {
        return match ($this) {
            self::Submission => 'Submission Phase',
            self::Approval => 'Approval Phase',
            self::Assignment => 'Assignment Phase',
            self::Development => 'Development Phase',
            self::Testing => 'Testing Phase',
            self::Validation => 'Validation Phase',
            self::Completion => 'Completion Phase',
            self::Review => 'Review Phase',
        };
    }

    public function order(): int
    {
        return match ($this) {
            self::Submission => 1,
            self::Approval => 2,
            self::Assignment => 3,
            self::Development => 4,
            self::Testing => 5,
            self::Validation => 6,
            self::Completion => 7,
            self::Review => 8,
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function ordered(): array
    {
        $cases = self::cases();

        usort($cases, fn ($a, $b) => $a->order() <=> $b->order());
        
        return $cases;
    }
}
