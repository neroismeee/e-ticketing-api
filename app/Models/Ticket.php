<?php

namespace App\Models;

use Carbon\Carbon;
use Dom\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id',
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
        'hardware_problem',
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
    public function reportedTickets()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function assignedTickets()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function convertedBy()
    {
        return $this->belongsTo(User::class, 'converted_by');
    }

    public function parentTicket()
    {
        return $this->belongsTo(Ticket::class, 'parent_ticket_id', 'id');
    }

    public function childTicket()
    {
        return $this->hasMany(Ticket::class, 'parent_ticket_id', 'id');
    }

    public function featureRequest()
    {
        return $this->hasOne(FeatureRequest::class, 'source_ticket_id');
    }
    
    public function errorReport()
    {
        return $this->hasOne(ErrorReport::class, 'source_ticket_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // helpers
    public function isConverted()
    {
        return $this->status === 'converted';
    }

    public function canBeConverted()
    {
        return in_array($this->status, [
            'pending_approval', 
            'assigned', 
            'in_progress', 
            'waiting_for_user'
        ]);
    }

    public function convertedUrl()
    {
        if (!$this->isConverted()) return null;

        return match($this->converted_to_type) {
            'error_report' => route('error-report.show', $this->converted_to_id),
            'feature_request' => route('feature-request.show', $this->converted_to_id),
            'default' => null
        };
    }

}
