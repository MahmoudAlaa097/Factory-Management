<?php

namespace App\Actions\V1\Fault;

use App\Models\Fault;
use App\Models\FaultComponent;
use App\Services\FaultService;

class DetachFaultComponentAction
{
    public function __construct(private FaultService $service) {}

    public function execute(Fault $fault, FaultComponent $faultComponent): Fault
    {
        return $this->service->detachComponent($fault, $faultComponent);
    }
}
