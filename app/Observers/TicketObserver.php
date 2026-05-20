<?php

namespace App\Observers;

use App\Models\Ticket;
use App\Services\Log\ActivityLogService;

class TicketObserver
{
    public function __construct(
        private readonly ActivityLogService $logService
    ) {}

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $this->logService->logCreated($ticket, [
            'title' => $ticket->title,
            'priority' => $ticket->priority,
            'status' => $ticket->status,
        ]);
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $changes = array_keys($ticket->getChanges());

        if ($changes === ['status']) {
            return;
        }

        if (array_key_exists('assigned_to_id', $changes)) {
            $ticket->loadMissing('assignee');

            $this->logService->logAssigned(
                loggable: $ticket,
                assigneeName: $ticket->assignee?->name ?? 'Unknown'
            );

            if ($changes === ['assigned_to_id', 'updated_at']) {
                return;
            }
        }

        $changedFields = array_diff(
            $changes,
            ['updated_at', 'status', 'assigned_to_id']
        );

        if (!empty($changedFields)) {
            $this->logService->logUpdated($ticket, $changedFields);
        }
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
