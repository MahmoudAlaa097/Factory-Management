<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\MachineSection\GetSectionComponentsAction;
use App\Actions\V1\MachineSection\ListMachineSectionsAction;
use App\Actions\V1\MachineSection\ShowMachineSectionAction;
use App\Http\Requests\Api\V1\ListMachineSectionsRequest;
use App\Http\Resources\V1\MachineComponentResource;
use App\Http\Resources\V1\MachineSectionResource;
use App\Models\MachineSection;
use Illuminate\Http\JsonResponse;

class MachineSectionController extends BaseController
{
    public function __construct(
        private ListMachineSectionsAction    $listAction,
        private ShowMachineSectionAction     $showAction,
        private GetSectionComponentsAction   $getComponentsAction,
    ) {}

    public function index(ListMachineSectionsRequest $request): JsonResponse
    {
        $this->authorize('viewAny', MachineSection::class);

        $sections = $this->listAction->execute();

        return $this->successCollection(
            'Machine sections retrieved successfully',
            MachineSectionResource::collection($sections),
            $sections
        );
    }

    public function show(MachineSection $machineSection): JsonResponse
    {
        $this->authorize('view', $machineSection);

        $machineSection = $this->showAction->execute($machineSection);

        return $this->successResource(
            'Machine section retrieved successfully',
            new MachineSectionResource($machineSection)
        );
    }

    /**
     * GET /api/v1/machine-sections/{machineSection}/components
     * Returns all components belonging to this section.
     * No pagination — intended for select dropdowns.
     */
    public function components(MachineSection $machineSection): JsonResponse
    {
        $this->authorize('view', $machineSection);

        $components = $this->getComponentsAction->execute($machineSection);

        return $this->successResource(
            'Section components retrieved successfully',
            MachineComponentResource::collection($components)
        );
    }
}
