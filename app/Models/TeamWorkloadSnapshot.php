<?php

namespace App\Models;

use App\Enums\AssignedTeam;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'team',
    'total_tickets',
    'open_tickets',
    'resolved_tickets',
    'overdue_tickets',
    'average_response_time',
    'average_resolution_time',
    'sla_compliance',
    'workload_percentage',
    'snapshot_date',
    'created_at'
])]
#[WithoutTimestamps]

class TeamWorkloadSnapshot extends Model
{
    public $casts = [
        'team' => AssignedTeam::class,
        'total_tickets' => 'integer',
        'open_tickets' => 'integer',
        'resolved_tickets' => 'integer',
        'overdue_tickets' => 'integer',
        'average_response_time' => 'decimal:2',
        'average_resolution_time' => 'decimal:2',
        'sla_compliance' => 'decimal:2',
        'workload_percentage' => 'decimal:2',
        'snapshot_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }
        });
    }

    // Scopes
    public function scopeByTeam(Builder $query, string $team): Builder
    {
        return $query->where('team', $team);
    }

    public function scopeByDate(Builder $query, string $date): Builder
    {
        return $query->where('snapshot_date', $date);
    }

    public function scopeInDateRange(Builder $query, string $from, string $to) : Builder 
    {
        return $query->whereBetween('snapshot_date', [$from, $to]);    
    }

    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('snapshot_date');
    }
}
