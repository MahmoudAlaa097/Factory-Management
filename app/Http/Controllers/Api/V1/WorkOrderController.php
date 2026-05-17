<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreWorkOrderRequest;
use App\Http\Resources\V1\WorkOrderResource;
use App\Models\WorkOrder;
use App\Services\WorkOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class WorkOrderController extends Controller
{
    public function __construct(
        private readonly WorkOrderService $workOrderService,
    ) {}

    public function index(): AnonymousResourceCollection
    {
        return WorkOrderResource::collection(
            $this->workOrderService->listWorkOrders()
        );
    }

    public function store(StoreWorkOrderRequest $request): JsonResponse
    {
        $workOrder = $this->workOrderService->create($request->validated());

        return (new WorkOrderResource($workOrder))
            ->response()
            ->setStatusCode(201);
    }

    public function show(WorkOrder $workOrder): WorkOrderResource
    {
        return new WorkOrderResource(
            $workOrder->load([
                'machine',
                'loggedBy',
                'technicians',
                'components.section',
                'components.component',
                'requester',
            ])
        );
    }

    /**
     * GET /v1/work-orders/tags
     * Distinct task_tag values for combobox suggestions.
     */
    public function tags(): JsonResponse
    {
        return response()->json([
            'data' => $this->workOrderService->distinctTags(),
        ]);
    }
}
