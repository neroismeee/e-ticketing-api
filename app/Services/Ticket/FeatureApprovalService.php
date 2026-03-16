<?php

namespace App\Services\Ticket;

use App\Exceptions\AlreadyProcessedException;
use App\Models\FeatureRequest;
use Illuminate\Support\Facades\DB;

class FeatureApprovalService
{
    public function processFeatureRequest(string $id, array $data): FeatureRequest
    {
        return DB::transaction(function () use ($id, $data) {
            $featureRequest = FeatureRequest::lockForUpdate()->findOrFail($id);

            $this->validate($featureRequest->id, $featureRequest->status);

            $updateData = $data['status'] === 'approved' ? $this->approvedData($data) : $this->rejectionData($data);
            $featureRequest->update($updateData);

            return $featureRequest->fresh();
        });
    }

    // helpers
    private function validate(string $id, string $currentStatus): void 
    {
        if ($currentStatus !== 'pending_approval') {
            throw new AlreadyProcessedException(
                id: $id,
                currentStatus: $currentStatus 
            );
        }
    }

    private function approvedData(array $data)
    {
        return [
            'status' => 'approved',
            'approved_by' => $data['approved_by'],
            'approval_date' => $data['approval_date'],
            'rejection_reason' => null
        ];
    }

    private function rejectionData(array $data)
    {
        return [
            'status' => 'rejected',
            'approved_by' => null,
            'approval_date' => null,
            'rejection_reason' => $data['rejection_reason']
        ];
    }
}