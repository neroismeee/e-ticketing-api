<?php

namespace App\Http\Controllers\Api\v1;

use App\Enums\AssignedTeam;
use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeamWorkloadSnapshotResource;
use App\Models\TeamWorkloadSnapshot;
use App\Services\TeamWorkloadSnapshotService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeamWorkloadSnapshotController extends Controller
{
    public function __construct(
        private readonly TeamWorkloadSnapshotService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $snapshots = $this->service->getAll(
            filters: $request->only(['team', 'date', 'from', 'to']),
            perPage: $request->integer('per_page', 15)
        );

        return ApiResponse::paginated(
            $snapshots,
            TeamWorkloadSnapshotResource::collection($snapshots),
            'Team workload snapshots retrieved successfully'
        );
    }

    public function latest(): JsonResponse
    {
        $snapshots = $this->service->getLatestPerTeam();

        return ApiResponse::success(
            TeamWorkloadSnapshotResource::collection($snapshots),
            'Latest team workload snapshots retrieved successfully'
        );
    }

    public function compare(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
        ]);

        $snapshots = $this->service->compareTeams($validated['date']);

        return ApiResponse::success(
            TeamWorkloadSnapshotResource::collection($snapshots),
            'Team workload comparison retrieved successfully'
        );
    }

    public function history(Request $request, string $team): JsonResponse
    {
        $validated = $request->validate([
            'from' => ['required', 'date'],
            'to' => ['required', 'date', 'after_or_equal:from'],
        ]);

        if (! AssignedTeam::tryFrom($team)) {
            return ApiResponse::error(
                "Invalid team '{$team}'. Valid values: " . implode(',', AssignedTeam::values()),
                422
            );
        }

        $snapshots = $this->service->getTeamHistory(
            team: $team,
            from: $validated['from'],
            to: $validated['to'],
            perPage: $request->integer('per_page', 30),
        );

        return ApiResponse::paginated(
            $snapshots,
            TeamWorkloadSnapshotResource::collection($snapshots),
            "Workload history for team '{$team}' retrieved successfully."
        );
    }

    public function show(TeamWorkloadSnapshot $snapshot): JsonResponse
    {
        return ApiResponse::success(
            new TeamWorkloadSnapshotResource($snapshot),
            'Team workload snapshot retrieved successfully'
        );
    }

    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'date' => ['nullable', 'date'],
            'team' => ['nullable', 'string', Rule::in(AssignedTeam::values())],
        ]);

        $date = $validated['date'] ?? now()->format('Y-m-d');
        $team = $validated['team'] ?? null;

        if ($team) {
            $assignedTeam = AssignedTeam::from($team);
            $snapshot = $this->service->generateForTeam($assignedTeam, $date);

            return ApiResponse::success(
                new TeamWorkloadSnapshotResource($snapshot),
                "Workload snapshot generated for team '{$team}'."
            );
        }

        $snapshots = $this->service->generateForDate($date);

        return ApiResponse::success(
            TeamWorkloadSnapshotResource::collection($snapshots),
            "Workload snapshots generated for all teams on {$date}."
        );
    }
}
