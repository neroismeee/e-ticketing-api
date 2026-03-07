<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class TicketService
{
    public function generateTicketId(): string
    {
        return DB::transaction(function () {
            $prefix = 'TKT';
            $year = now()->format('Y');

            $lastTicket = Ticket::where('id', 'like', "{$prefix}-{$year}-%")
            ->lockForUpdate()
            ->orderBy('id', 'desc')
            ->first();

            $lastNumber = $lastTicket ? (int) substr($lastTicket->id, -3) : 0;
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

            return "{$prefix}-{$year}-{$newNumber}";
        });
    }
}