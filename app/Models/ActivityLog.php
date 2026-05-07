<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Override;

#[Fillable([
    'loggable_id',
    'loggable_type',
    'action',
    'description',
    'performed_by',
    'performed_at',
    'details',
    'target_user_id',
])]

#[WithoutTimestamps]

class ActivityLog extends Model
{
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model->performed_at)) {
                $model->performed_at = now();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'performed_at' => 'datetime'
        ];
    }

    // Relations
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function performer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}
