<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\ComponentReplacement\ListComponentReplacementsAction;
use App\Actions\V1\ComponentReplacement\LogComponentReplacementAction;
use App\Actions\V1\ComponentReplacement\ShowComponentReplacementAction;
use App\Http\Requests\Api\V1\ListComponentReplacementsRequest;
use App\Http\Requests\Api\V1\StoreComponentReplacementRequest;
use App\Http\Resources\V1\ComponentReplacementResource;
use App\Http\Responses\ApiResponse;
use App\Models\ComponentReplacement;
use App\Models\Fault;
use Illuminate\Http\JsonResponse;

class ComponentReplacementController extends BaseController
{
    public function __construct(
        private ListComponentReplacementsAction $listAction,
        private ShowComponentReplacementAction  $showAction,
        private LogComponentReplacementAction   $logAction,
    ) {}

    public function index(ListComponentReplacementsRequest $request, Fault $fault): JsonResponse
    {
        $this->authorize('viewReplacements', $fault);

        $replacements = $this->listAction->execute();

        return $this->successCollection(
            'Component replacements retrieved successfully',
            ComponentReplacementResource::collection($replacements),
            $replacements
        );
    }

    public function show(Fault $fault, ComponentReplacement $componentReplacement): JsonResponse
    {
        $this->authorize('viewReplacements', $fault);

        $componentReplacement = $this->showAction->execute($componentReplacement);

        return $this->successResource(
            'Component replacement retrieved successfully',
            new ComponentReplacementResource($componentReplacement)
        );
    }

    public function store(StoreComponentReplacementRequest $request, Fault $fault): JsonResponse
    {
        $replacement = $this->logAction->execute($request, $fault, $request->user());

        return ApiResponse::success(
            'Component replacement logged successfully',
            new ComponentReplacementResource($replacement),
            null,
            201
        );
    }
}
