<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
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
        'created_at',
        'updated_at',
    ];

}
