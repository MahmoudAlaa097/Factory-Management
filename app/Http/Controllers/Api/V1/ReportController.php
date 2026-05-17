<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\DailyReportResource;
use App\Models\Management;
use App\Services\DailyReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        private readonly DailyReportService $dailyReportService,
    ) {}

    /**
     * GET /api/v1/reports/daily?date=2026-05-13&management_id=1
     */
    public function daily(Request $request): JsonResponse
    {
        $request->validate([
            'date'          => ['required', 'date'],
            'management_id' => ['required', 'integer', 'exists:managements,id'],
        ]);

        $management = Management::findOrFail($request->integer('management_id'));
        $preparedBy = $request->user()->employee->name;

        $report = $this->dailyReportService->build(
            date:       $request->date,
            management: $management,
            preparedBy: $preparedBy,
        );

        return response()->json(
            (new DailyReportResource($report))->toArray($request)
        );
    }
}
