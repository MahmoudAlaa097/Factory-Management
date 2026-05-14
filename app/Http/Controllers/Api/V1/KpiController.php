<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KpiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KpiController extends Controller
{
    public function __construct(
        private readonly KpiService $kpiService,
    ) {}

    public function workOrders(Request $request): JsonResponse
    {
        $from = $request->date('from', now()->startOfMonth());
        $to   = $request->date('to', now());

        $stats = $this->kpiService->workOrderStats(
            from:      $from,
            to:        $to,
            machineId: $request->integer('machine_id') ?: null,
            type:      $request->string('type')->toString() ?: null,
        );

        return response()->json($stats);
    }
}
