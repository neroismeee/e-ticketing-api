<?php

namespace App\Observers;

use App\Models\ErrorReport;
use App\Services\Log\ActivityLogService;

class ErrorReportObserver
{
    public function __construct(
        private readonly ActivityLogService $logService
    ) {}
    /**
     * Handle the ErrorReport "created" event.
     */
    public function created(ErrorReport $errorReport): void
    {
        $this->logService->logCreated($errorReport, [
            'title' => $errorReport->title,
            'priority' => $errorReport->priority,
            'status' => $errorReport->status
        ]);
    }

    /**
     * Handle the ErrorReport "updated" event.
     */
    public function updated(ErrorReport $errorReport): void
    {
        $dirty = array_keys($errorReport->getDirty());

        if ($dirty === ['status']) {
            return;
        }

        if (array_key_exists('assigned_to', $dirty)) {
            $errorReport->loadMissing('assignee');

            $this->logService->logAssigned(
                loggable: $errorReport,
                assigneeName: $errorReport->assignee?->name ?? 'Unknown'
            );

            if (array_keys($dirty) === ['assigned_to']) {
                return;
            }
        }
        
        $changedFields = array_keys(
            array_diff_key($dirty, array_flip(['status', 'assigned_to']))
        );

        $this->logService->logUpdated($errorReport, $changedFields);
    }

    /**
     * Handle the ErrorReport "deleted" event.
     */
    public function deleted(ErrorReport $errorReport): void
    {
        //
    }

    /**
     * Handle the ErrorReport "restored" event.
     */
    public function restored(ErrorReport $errorReport): void
    {
        //
    }

    /**
     * Handle the ErrorReport "force deleted" event.
     */
    public function forceDeleted(ErrorReport $errorReport): void
    {
        //
    }
}
