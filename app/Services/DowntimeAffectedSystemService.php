<?php

namespace App\Services;

use App\Models\DowntimeAffectedSystem;
use App\Models\DowntimeRecord;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class DowntimeAffectedSystemService
{
    public function addSystems(DowntimeRecord $downtime, array $systemNames): Collection
    {
        $existingSystems = $downtime->affectedSystems()
            ->pluck('system_name')
            ->toArray();

        $newSystems = array_filter(
            array_unique($systemNames),
            fn($name) => ! in_array($name, $existingSystems)
        );

        if (empty($newSystems)) {
            throw ValidationException::withMessages([
                'system_names' => [
                    'All specified systems are already added to this downtime record.'
                ]
            ]);
        }

        $rows = array_map(fn($name) => [
            'downtime_id' => $downtime->id,
            'system_name' => $name
        ], $newSystems);

        DowntimeAffectedSystem::insert($rows);

        return $this->getSystems($downtime);
    }

    public function removeSystem(DowntimeRecord $downtime, array $systemNames): Collection
    {
        $existingSystems = $downtime->affectedSystems()
            ->pluck('system_name')
            ->toArray();

        $validSystems = array_intersect($systemNames, $existingSystems);

        if (empty($validSystems)) {
            throw ValidationException::withMessages([
                'system_names' => [
                    'None of the specified systems are attached to this downtime record.'
                ]
            ]);
        }

        DowntimeAffectedSystem::where('downtime_id', $downtime->id)
            ->whereIn('system_name', $validSystems)
            ->delete();

        return $this->getSystems($downtime);
    }

    public function syncSystems(DowntimeRecord $downtime, array $systemNames): Collection
    {
        DowntimeAffectedSystem::where('downtime_id', $downtime->id)->delete();

        if (! empty($systemNames)) {
            $rows = array_map(fn($name) => [
                'downtime_id' => $downtime->id,
                'system_name' => $name
            ], array_unique($systemNames));

            DowntimeAffectedSystem::insert($rows);
        }

        return $this->getSystems($downtime);
    }

    //* Query
    public function getSystems(DowntimeRecord $downtime): Collection
    {
        return $downtime->affectedSystems()->get();
    }
}
