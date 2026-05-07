<?php

namespace App\Enums;

enum ActivityAction: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Assigned = 'assigned';
    case Commented = 'commented';
    case StatusChanged = 'status_changed';
    case AttachmentAdded = 'attachment_added';
    case MilestoneReached = 'milestone_reached';
    case MentionAdded = 'mention_added';
    case Converted = 'converted';

    public function label(): string
    {
        return match($this) {
            self::Created => 'Created',
            self::Updated => 'Updated',
            self::Assigned => 'Assigned',
            self::Commented => 'Commented',
            self::StatusChanged => 'Status Changed',
            self::AttachmentAdded => 'Attachment Added',
            self::MilestoneReached => 'Milestone Reached',
            self::MentionAdded => 'Mentioned',  
            self::Converted => 'Converted',
        };
    }   
}   
