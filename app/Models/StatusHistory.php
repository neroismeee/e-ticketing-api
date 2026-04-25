<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\WithoutTimestamps;
use Illuminate\Database\Eloquent\Model;

use function Symfony\Component\Clock\now;

#[WithoutTimestamps]
#[Fillable([
    'statusable_type',
    'statusable_id',
    'previous_status',
    'new_status',
    'changed_by',
    'changed_at',
    'reason',
    'notes',
])]

class StatusHistory extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $model) {
            if (empty($model)) {
                $model->changed_at = now();
            }
        });
    }
    // Relation
    public function statusable()
    {
        return $this->morphTo();
    }
    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function errorReport()
    {
        return $this->belongsTo(ErrorReport::class, 'error_report_id');
    }
    public function featureRequest()
    {
        return $this->belongsTo(FeatureRequest::class, 'feature_request_id');
    }
    public function changer()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
