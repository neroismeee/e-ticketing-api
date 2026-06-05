<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutIncrementing;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'downtime_id',
    'system_name',
])]
#[WithoutIncrementing]
#[WithoutTimestamps]

class DowntimeAffectedSystem extends Model
{
    // Relations
    public function downtime(): BelongsTo
    {
        return $this->belongsTo(DowntimeRecord::class, 'downtime_id');
    }
}
