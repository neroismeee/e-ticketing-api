<?php

namespace App\Traits;

use App\Models\Comment;

trait HasComments
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function publicComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('is_internal', false);
    }

    public function internalComments()
    {
        return $this->morphMany(Comment::class, 'commentable')->where('is_internal', true);
    }

    // Helpers
    public function hasComments(): bool
    {
        return $this->comments()->exists();
    }

    public function commentCounts(): int
    {
        return $this->comments()->count();
    }
}
