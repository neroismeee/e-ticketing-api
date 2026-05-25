<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

#[Fillable([
    'feature_request_id',
    'title',
    'description',
    'target_date',
    'completed_date',
    'is_completed',
    'progress',
    'created_by',
    'created_at'
])]

#[WithoutTimestamps]

class Milestone extends Model
{
    protected $casts = [
        'target_date' => 'datetime',
        'completed_date' => 'datetime',
        'is_completed' => 'boolean',
        'progress' => 'integer',
        'created_at' => 'datetime',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->created_at)) {
                $model->created_at = now();
            }

            if (empty($model->created_by)) {
                $model->created_by = Auth::id();
            }
        }); 
    }

    // Relation
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function featureRequest(): BelongsTo
    {
        return $this->belongsTo(FeatureRequest::class, 'feature_request_id');
    }

    // Helper
    public function isCompleted(): bool
    {
        return $this->is_completed === true;
    }

    public function isOverdue(): bool
    {
        return ! $this->isCompleted() && now()->isAfter($this->target_date);
    }

    public function getDaysRemainingAttribute(): int
    {
        return (int) now()->diffInDays($this->target_date, false);
    }
}
