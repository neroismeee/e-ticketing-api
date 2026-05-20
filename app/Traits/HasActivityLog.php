<?php

namespace App\Traits;

use App\Enums\ActivityAction;
use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;

trait HasActivityLog
{
    public function activityLogs(): MorphMany
    {
        /** @var Model $this */
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function activityLogByAction(ActivityAction $action): MorphMany
    {
        /** @var Model $this */

        return $this->morphMany(ActivityLog::class, 'loggable')
            ->where('action', $action->value);
    }

    public function latestActivityLog(): MorphMany
    {
        /** @var Model $this */

        return $this->morphMany(ActivityLog::class, 'loggable')
            ->latest('performed_at')
            ->limit(1);
    }

    // Helpers
    public function hasActivityLog(): bool
    {
        return $this->activityLogs()->exists();
    }

    public function activityLogCount(): int
    {
        return $this->activityLogs()->count();
    }
}
