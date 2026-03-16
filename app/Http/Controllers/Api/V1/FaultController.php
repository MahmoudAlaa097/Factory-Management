<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Fault\AcceptFaultAction;
use App\Actions\V1\Fault\ApproveMaintenanceFaultAction;
use App\Actions\V1\Fault\CloseFaultAction;
use App\Actions\V1\Fault\ListFaultsAction;
use App\Actions\V1\Fault\ReportFaultAction;
use App\Actions\V1\Fault\ResolveFaultAction;
use App\Actions\V1\Fault\RespondToFaultAction;
use App\Actions\V1\Fault\ShowFaultAction;
use App\Http\Requests\Api\V1\AcceptFaultRequest;
use App\Http\Requests\Api\V1\ApproveMaintenanceFaultRequest;
use App\Http\Requests\Api\V1\CloseFaultRequest;
use App\Http\Requests\Api\V1\ListFaultsRequest;
use App\Http\Requests\Api\V1\ResolveFaultRequest;
use App\Http\Requests\Api\V1\RespondToFaultRequest;
use App\Http\Requests\Api\V1\StoreFaultRequest;
use App\Http\Resources\V1\FaultResource;
use App\Http\Responses\ApiResponse;
use App\Models\Fault;
use Illuminate\Http\JsonResponse;

class FaultController extends BaseController
{
    public function __construct(
        private ListFaultsAction              $listAction,
        private ShowFaultAction               $showAction,
        private ReportFaultAction             $reportAction,
        private RespondToFaultAction          $respondAction,
        private ResolveFaultAction            $resolveAction,
        private AcceptFaultAction             $acceptAction,
        private ApproveMaintenanceFaultAction $approveAction,
        private CloseFaultAction              $closeAction,
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

    public function respond(RespondToFaultRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->respondAction->execute($request, $fault, $request->user());

        return ApiResponse::success(
            'Fault is now in progress',
            new FaultResource($fault)
        );
    }

    public function resolve(ResolveFaultRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->resolveAction->execute($fault);

        return ApiResponse::success(
            'Fault resolved successfully',
            new FaultResource($fault)
        );
    }

    public function accept(AcceptFaultRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->acceptAction->execute($fault);

        return ApiResponse::success(
            'Fault accepted successfully',
            new FaultResource($fault)
        );
    }

    public function approve(ApproveMaintenanceFaultRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->approveAction->execute($fault, $request->user());

        return ApiResponse::success(
            'Fault approved by maintenance successfully',
            new FaultResource($fault)
        );
    }

    public function close(CloseFaultRequest $request, Fault $fault): JsonResponse
    {
        $fault = $this->closeAction->execute($fault, $request->user());

        return ApiResponse::success(
            'Fault closed successfully',
            new FaultResource($fault)
        );
    }
}
