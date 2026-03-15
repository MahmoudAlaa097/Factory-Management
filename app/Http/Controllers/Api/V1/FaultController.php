<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Fault\ListFaultsAction;
use App\Actions\V1\Fault\ShowFaultAction;
use App\Actions\V1\Fault\ReportFaultAction;
use App\Http\Requests\Api\V1\ListFaultsRequest;
use App\Http\Requests\Api\V1\StoreFaultRequest;
use App\Http\Resources\V1\FaultResource;
use App\Http\Responses\ApiResponse;
use App\Models\Fault;
use Illuminate\Http\JsonResponse;

class FaultController extends BaseController
{
    public function __construct(
        private ListFaultsAction  $listAction,
        private ShowFaultAction   $showAction,
        private ReportFaultAction $reportAction,
    ) {}

    public function index(ListFaultsRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Fault::class);

        $faults = $this->listAction->execute($request->user());

        return $this->successCollection(
            'Faults retrieved successfully',
            FaultResource::collection($faults),
            $faults
        );
    }

    public function show(Fault $fault): JsonResponse
    {
        $this->authorize('view', $fault);

        $fault = $this->showAction->execute($fault);

        return $this->successResource(
            'Fault retrieved successfully',
            new FaultResource($fault)
        );
    }

    public function store(StoreFaultRequest $request): JsonResponse
    {
        $fault = $this->reportAction->execute($request, $request->user());

        return ApiResponse::success(
            'Fault reported successfully',
            new FaultResource($fault),
            null,
            201
        );
    }
}
