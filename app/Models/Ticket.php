<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $fillable = [
        'title',
        'description',
        'category',
        'priority',
        'status',
        'reporter_id',
        'assigned_to_id',
        'assigned_team',
        'date_reported',
        'due_date',
        'resolved_date',
        'closed_date',
        'sla_breached',
        'response_time',
        'resolution_time',
        'estimated_effort',
        'actual_effort',
        'parent_ticket_id',
        'converted_to_type',
        'converted_to_id',
        'converted_at',
        'converted_by',
        'conversion_reason',
    ];

    protected $casts = [
        'date_reported' => 'datetime',
        'due_date' => 'datetime',
        'resolved_date' => 'datetime',
        'closed_date' => 'datetime',
        'converted_at' => 'datetime',
        'sla_breached' => 'boolean',
        'response_time' => 'integer',
        'resolution_time' => 'integer',
        'estimated_effort' => 'integer',
        'actual_effort' => 'integer',
    ];

    public const CATEGORIES = [
        'software_bug',
        'feature_request',
        'network_issue',
        'hardware_failure',
        'system_error',
        'performance_issue',
    ];

    public const PRIORITIES = [
        'low',
        'medium',
        'high',
        'critical',
    ];

    public const STATUSES = [
        'draft',
        'pending_approval',
        'assigned',
        'in_progress',
        'waiting_for_user',
        'resolved',
        'closed',
        'converted',

    ];

    public const ASSIGNED_TEAMS = [
        'programmer',
        'network',
        'hardware',
    ];
    
    public const CONVERTED_TO_TYPES = [
        'error_report',
        'feature_request',
    ];

    // Relations
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function convertedBy()
    {
        return $this->belongsTo(User::class, 'converted_by');
    }

    public function parentTicket()
    {
        return $this->belongsTo(Ticket::class, 'parent_ticket_id');
    }

    

}
