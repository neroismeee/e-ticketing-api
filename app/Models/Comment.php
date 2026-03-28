<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'ticket_id',
    'error_report_id',
    'feature_request_id',
    'user_id',
    'content',
    'is_internal',
    'created_at',
    'updated_at'
])]

class Comment extends Model
{
    // relations
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
