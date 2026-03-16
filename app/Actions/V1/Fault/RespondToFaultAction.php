<?php

namespace App\Actions\V1\Fault;

use App\Http\Requests\Api\V1\RespondToFaultRequest;
use App\Models\Fault;
use App\Models\User;
use App\Services\FaultService;

class RespondToFaultAction
{
    public function __construct(private FaultService $service) {}

    public function execute(RespondToFaultRequest $request, Fault $fault, User $user): Fault
    {
        return $this->service->respond($fault, $user);
    }
}
