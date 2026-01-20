<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureRequest extends Model
{
    protected $table = 'feature_requests';
    protected $fillable = [
        'id',
        'title',
        'description',
        'request_type',
        'priority',
        'status',
        'progress',
        'reporter_id',
        'assigned_to_id',
        'assigned_team',
        'date_submitted',
        'approval_date',
        'assigned_date',
        'start_date',
        'due_date',
        'completion_date',
        'review_date',
        'esimated_effort',
        'actual_effort',
        'sla_time_elapsed',
        'sla_time_remaining',
        'sla_breached',
        'approved_by',
        'rejection_reason',
        'roi_impact',
        'quality_impact',
        'post_implementation_notes',
        'source_ticket_id',
        'is_direct_input',
        'created_at',
        'updated_at',
    ];
}
