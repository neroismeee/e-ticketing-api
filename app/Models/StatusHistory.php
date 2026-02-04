<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $table = 'status_history';
    protected $fillable = [
        'id',
        'ticket_id',
        'error_report_id',
        'feature_request_id',
        'previous_status',
        'new_status',
        'changed_by',
        'changed_at',
        'reason',
        'notes'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function featureRequest()
    {
        return $this->belongsTo(FeatureRequest::class, 'feature_request_id');
    }

    public function errorReport()
    {
        return $this->belongsTo(ErrorReport::class, 'error_report_id');
    }

    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

}
