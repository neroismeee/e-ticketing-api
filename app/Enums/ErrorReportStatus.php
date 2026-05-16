<?php

namespace App\Enums;

enum ErrorReportStatus: string
{
    case PendingApproval = 'pending_approval'; 
    case InProgress = 'in_progress'; 
    case Completed = 'completed'; 
    case Overdue = 'overdue'; 

    public function label(): string
    {
        return match ($this) {
            self::PendingApproval => 'Pending Approval',
            self::InProgress => 'In Progress',
            self::Completed => 'Completed',
            self::Overdue => 'Overdue',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function assignableStatuses(): array
    {
        return [
            self::PendingApproval->value,
            self::InProgress->value,
        ];
    }

    public function isFinal(): bool
    {
        return in_array($this, [
            self::Completed,
            self::Overdue
        ], true);
    }
}
