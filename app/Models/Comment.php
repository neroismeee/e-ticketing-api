<?php

namespace App\Models;

use App\Http\Controllers\api\v1\Comment\MentionController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'commentable_id',
    'commentable_type',
    'user_id',
    'content',
    'is_internal',
])]

class Comment extends Model
{
    // helpers
    public function scopePublic($query)
    {
        $query->where('is_internal', false);
    }

    public function scopeInternal($query)
    {
        $query->where('is_internal', true);
    }

    // relations
    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mentions()
    {
        return $this->hasMany(CommentMention::class, 'comment_id');
    }
}
