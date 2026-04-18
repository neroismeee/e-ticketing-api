<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'size',
    'type',
    'url',
    'attachmentable_id',
    'attachmentable_type',
    'comment_id',
    'uploaded_by',
    'uploaded_at',
])]

class Attachment extends Model
{
    // Relations
    public function attachmentable()
    {
        return $this->morphTo();
    }

    public function uploader()
    {
        return $this->hasOne(User::class, 'uploaded_by');
    }
}
