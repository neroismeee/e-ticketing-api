<?php

namespace App\Observers;

use App\Models\FeatureRequest;
use App\Services\Log\ActivityLogService;

class FeatureRequestObserver
{
    public function __construct(
        private readonly ActivityLogService $logService
    ) {}
    /**
     * Handle the FeatureRequest "created" event.
     */
    public function created(FeatureRequest $featureRequest): void
    {
        $this->logService->logCreated($featureRequest, [
            'title' => $featureRequest->title,
            'priority' => $featureRequest->priority,
            'status' => $featureRequest->status
        ]);
    }

    /**
     * Handle the FeatureRequest "updated" event.
     */
    public function updated(FeatureRequest $featureRequest): void
    {
        $dirty = array_keys($featureRequest->getDirty());

        if ($dirty === ['status']) {
            return;
        }

        if (array_key_exists('assigned_to', $dirty)) {
            $featureRequest->loadMissing('assignee');

            $this->logService->logAssigned(
                loggable: $featureRequest,
                assigneeName: $featureRequest->assignee?->name ?? 'Unknown'
            );

            if (array_keys($dirty) === ['assigned_to']) {
                return;
            }
        }

        $changedFields = array_keys(
            array_diff_key($dirty, array_flip(['status', 'assigned_to']))
        );

        $this->logService->logUpdated($featureRequest, $changedFields);
    }

    /**
     * Handle the FeatureRequest "deleted" event.
     */
    public function deleted(FeatureRequest $featureRequest): void
    {
        //
    }

    /**
     * Handle the FeatureRequest "restored" event.
     */
    public function restored(FeatureRequest $featureRequest): void
    {
        //
    }

    /**
     * Handle the FeatureRequest "force deleted" event.
     */
    public function forceDeleted(FeatureRequest $featureRequest): void
    {
        //
    }
}
