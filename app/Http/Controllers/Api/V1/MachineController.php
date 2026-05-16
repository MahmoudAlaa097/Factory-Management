<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Machine\ListMachinesForUserAction;
use App\Actions\V1\Machine\ShowMachineAction;
use App\Actions\V1\MachineSection\GetMachineSectionsAction;
use App\Http\Requests\Api\V1\ListMachinesRequest;
use App\Http\Resources\V1\MachineResource;
use App\Http\Resources\V1\MachineSectionResource;
use App\Models\Machine;
use Illuminate\Http\JsonResponse;

class MachineController extends BaseController
{
    public function __construct(
        private ListMachinesForUserAction $listAction,
        private ShowMachineAction         $showAction,
        private GetMachineSectionsAction  $getSectionsAction,
    ) {}

    public function index(ListMachinesRequest $request): JsonResponse
    {
        $this->authorize('viewAny', Machine::class);

        $machines = $this->listAction->execute($request->user());

        return $this->successCollection(
            'Machines retrieved successfully',
            MachineResource::collection($machines),
            $machines
        );
    }

    public function show(Machine $machine): JsonResponse
    {
        $this->authorize('view', $machine);

        $machine = $this->showAction->execute($machine);

        return $this->successResource(
            'Machine retrieved successfully',
            new MachineResource($machine)
        );
    }

    /**
     * GET /api/v1/machines/{machine}/sections
     */
    public function sections(Machine $machine): JsonResponse
    {
        $this->authorize('view', $machine);

        $sections = $this->getSectionsAction->execute($machine);

        return $this->successResource(
            'Machine sections retrieved successfully',
            MachineSectionResource::collection($sections)
        );
    }
}
