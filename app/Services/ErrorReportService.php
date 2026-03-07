<?php

namespace App\Services;

use App\Models\ErrorReport;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class ErrorReportService
{
    public function generateErrorReportId(): string
    {
        return DB::transaction(function () {
            $prefix = 'ERR';
            $year = now()->format('Y');

            $lastErrorReport = ErrorReport::where('id', 'like', "{$prefix}-{$year}-%")
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

            $lastNumber = $lastErrorReport ? (int) substr($lastErrorReport->id, -3) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            return "{$prefix}-{$year}-{$newNumber}";
        });
    }
}