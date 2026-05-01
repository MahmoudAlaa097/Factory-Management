<?php

namespace App\Actions\V1\Fault;

use App\Http\Requests\Api\V1\UpdateFaultResolutionRequest;
use App\Models\Fault;
use App\Services\FaultResolutionService;

class UpdateFaultResolutionAction
{
    public function __construct(private FaultResolutionService $service) {}

    public function execute(UpdateFaultResolutionRequest $request, Fault $fault): Fault
    {
        return $this->service->updateResolution($request, $fault);
    }
}
