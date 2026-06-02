<?php

namespace App\Enums;

enum NotificationType: string
{
    case TicketAssigned = 'ticket_assigned';
    case TicketUpdated = 'ticket_updated';
    case SlaBreached = 'sla_breached';
    case DowntimeAlert = 'downtime_alert';
    case MaintenanceReminder = 'maintenance_reminder';
    case CommentMention = 'comment_mention';
    case TicketConverted = 'ticket_converted';

    public function label(): string
    {
        return match ($this) {
            self::TicketAssigned => 'Ticket Assigned',
            self::TicketUpdated => 'Ticket Updated',
            self::SlaBreached => 'SLA Breached',
            self::DowntimeAlert => 'Downtime Alert',
            self::MaintenanceReminder => 'Maintenance Reminder',
            self::CommentMention => 'Comment Mention',
            self::TicketConverted => 'Ticket Converted',
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
