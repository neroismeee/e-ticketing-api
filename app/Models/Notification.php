<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'type',
    'title',
    'message',
    'user_id',
    'ticket_id',
    'downtime_id',
    'is_read',
    'action_url',
    'priority'
])]

class Notification extends Model
{
    // Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
