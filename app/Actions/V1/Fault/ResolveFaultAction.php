<?php

namespace App\Actions\V1\Fault;

use App\Models\Fault;
use App\Services\FaultService;

class ResolveFaultAction
{
    public function __construct(private FaultService $service) {}

    public function execute(Fault $fault): Fault
    {
        return $this->service->resolve($fault);
    }
}
