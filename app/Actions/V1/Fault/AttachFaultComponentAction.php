<?php

namespace App\Actions\V1\Fault;

use App\Http\Requests\Api\V1\StoreFaultComponentRequest;
use App\Models\Fault;
use App\Services\FaultService;

class AttachFaultComponentAction
{
    public function __construct(private FaultService $service) {}

    public function execute(StoreFaultComponentRequest $request, Fault $fault): Fault
    {
        return $this->service->attachComponent($fault, $request->machine_component_id, $request->notes);
    }
}
