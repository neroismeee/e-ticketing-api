<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'ticket_id',
        'error_report_id',
        'feature_request_id',
        'user_id',
        'content',
        'is_internal',
        'created_at',
        'updated_at'
    ];

    // relations
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function error_report()
    {
        return $this->belongsTo(ErrorReport::class, 'error_report_id');
    }

    public function feature_request()
    {
        return $this->belongsTo(FeatureRequest::class, 'feature_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
