<?php

namespace App\Services;

use function Symfony\Component\Clock\now;

use App\Models\FeatureRequest;
use Illuminate\Support\Facades\DB;

class FeatureRequestService
{
    public function generateFeatureRequestId(): string
    {
        return DB::transaction(function () {
            $prefix = 'FR';
            $year = now()->format('Y');

            $lastFeatureRequest = FeatureRequest::where('id', 'like', "{$prefix}-{$year}-%")
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

            $lastNumber = $lastFeatureRequest ? (int) substr($lastFeatureRequest->id, -3) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            return "{$prefix}-{$year}-{$newNumber}";
        });
    }
}