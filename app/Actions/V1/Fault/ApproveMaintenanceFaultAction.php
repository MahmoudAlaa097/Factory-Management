<?php

namespace App\Actions\V1\Fault;

use App\Models\Fault;
use App\Models\User;
use App\Services\FaultService;

class ApproveMaintenanceFaultAction
{
    public function __construct(private FaultService $service) {}

    public function execute(Fault $fault, User $user): Fault
    {
        return $this->service->approveMaintenance($fault, $user);
    }
}
