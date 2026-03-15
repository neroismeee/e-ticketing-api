<?php

namespace App\Services\Ticket;

use App\Exceptions\ConversionFailedException;
use App\Models\ErrorReport;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\TicketAlreadyConvertedException;
use App\Exceptions\TicketCannotBeConvertedException;
use App\Models\FeatureRequest;
use Illuminate\Database\QueryException;

class TicketConversionService
{
    public function convertToErrorReport(string $ticketId, array $data): ErrorReport
    {
        return DB::transaction(function () use ($ticketId, $data) {
            try {

                $ticket = Ticket::lockForUpdate()->findOrFail($ticketId);

                if ($ticket->isConverted()) {
                    throw new TicketAlreadyConvertedException(
                        ticketId: $ticket->id,
                        convertedToType: $ticket->converted_to_type,
                        convertedToId: $ticket->converted_to_id,
                        convertedAt: $ticket->converted_at
                    );
                }
                
                if (!$ticket->canBeConverted()) {
                    throw new TicketCannotBeConvertedException(
                        ticketId: $ticket->id,
                        currentStatus: $ticket->status,
                    );
                }


                $errorReport = ErrorReport::create([
                    'id' => $this->generateCode('ERR'),
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'category' => $data['category'],
                    'priority' => $data['priority'],
                    'status' => 'pending_approval',
                    'reporter_id' => $ticket->reporter_id,
                    'assigned_to_id' => $ticket->assigned_to_id,
                    'assigned_team' => $ticket->assigned_team,
                    'date_reported' => Carbon::now(),
                    'start_date' => $data['start_date'] ?? null,
                    'due_date' => $data['due_date'] ?? null,
                    'completion_date' => $data['completion_date'] ?? null,
                    'estimated_effort' => $data['estimated_effort'] ?? null,
                    'actual_effort' => $data['actual_effort'] ?? null,
                    'sla_time_elapsed' => $data['sla_time_elapsed'] ?? null,
                    'sla_time_remaining' => $data['sla_time_remaining'] ?? null,
                    'sla_breached' => $data['sla_breached'] ?? false,
                    'source_ticket_id' => $ticket->id,
                    'is_direct_input' => false,
                ]);

                $ticket->update([
                    'status' => 'converted',
                    'converted_to_type' => 'error_report',
                    'converted_to_id' => $errorReport->id,
                    'converted_at' => Carbon::now(),
                    'converted_by' => Auth::id(),
                    'conversion_reason' => $data['conversion_reason']
                ]);

                return $errorReport;
            } catch (TicketAlreadyConvertedException | TicketCannotBeConvertedException $e) {
                throw $e;
            } catch (QueryException $e) {
                throw new ConversionFailedException(
                    ticketId: $ticket->id,
                    context: [
                        'sql' => $e->getSql(),
                        'message' => $e->getMessage()
                    ]
                );
            }
        });
    }

    public function convertToFeatureRequest(string $ticketId, array $data): FeatureRequest
    {
        return DB::transaction(function () use ($ticketId, $data) {
            try {
                $ticket = Ticket::lockForUpdate()->findOrFail($ticketId);

                if ($ticket->isConverted()) {
                    throw new TicketAlreadyConvertedException(
                        ticketId: $ticket->id,
                        convertedToType: $ticket->converted_to_type,
                        convertedToId: $ticket->converted_to_id,
                        convertedAt: $ticket->converted_at
                    );
                }

                if (!$ticket->canBeConverted()) {
                    throw new TicketCannotBeConvertedException(
                        ticketId: $ticket->id,
                        currentStatus: $ticket->status
                    );
                }


                $featureRequest = FeatureRequest::create([
                    'id' => $this->generateCode('FR'),
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'request_type' => $data['request_type'],
                    'priority' => $data['priority'],
                    'status' => 'submission',
                    'progress' => 0,
                    'reporter_id' => $ticket->reporter_id,
                    'assigned_to_id' => $ticket->assigned_to_id,
                    'date_submitted' => Carbon::now(),
                    'approval_date' => $data['approval_date'] ?? null,
                    'assignment_date' => $data['assignment_date'] ?? null,
                    'start_date' => $data['start_date'] ?? null,
                    'due_date' => $data['due_date'] ?? null,
                    'completion_date' => $data['completion_date'] ?? null,
                    'review_date' => $data['review_date'] ?? null,
                    'estimated_effort' => $data['estimated_effort'] ?? null,
                    'actual_effort' => $data['actual_effort'] ?? null,
                    'sla_time_elapsed' => $data['sla_time_elapsed'] ?? null,
                    'sla_time_remaining' => $data['sla_time_remaining'] ?? null,
                    'sla_breached' => $data['sla_breached'] ?? false,
                    'approved_by' => $data['approved_by'] ?? null,
                    'rejection_reason' => $data['rejection_reason'] ?? null,
                    'roi_impact' => $data['roi_impact'] ?? null,
                    'quality_impact' => $data['quality_impact'] ?? null,
                    'post_implementation_notes' => $data['post_implementation_notes'] ?? null,
                    'source_ticket_id' => $ticket->id,
                    'is_direct_input' => false,
                ]);

                $ticket->update([
                    'status' => 'converted',
                    'converted_to_type' => 'feature_request',
                    'converted_to_id' => $featureRequest->id,
                    'converted_at' => Carbon::now(),
                    'converted_by' => Auth::id(),
                    'conversion_reason' => $data['conversion_reason']
                ]);

                return $featureRequest;
            } catch (TicketAlreadyConvertedException | TicketCannotBeConvertedException $e) {
                throw $e;
            } catch (QueryException $e) {
                throw new ConversionFailedException(
                    ticketId: $ticket->id,
                    context: [
                        'sql' => $e->getSql(),
                        'message' => $e->getMessage()
                    ]
                );
            }
        });
    }

    // private helper
    private function generateCode(string $prefix): string
    {
        $year = now()->year;
        $model = $prefix === 'ERR' ? ErrorReport::class : FeatureRequest::class;

        $lastRecord = $model::whereYear('created_at', $year)
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

        if ($lastRecord) {
            $lastNumber = (int) substr($lastRecord->id, -3);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return sprintf('%s-%d-%03d', $prefix, $year, $nextNumber);
    }
}
