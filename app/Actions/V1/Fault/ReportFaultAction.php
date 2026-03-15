<?php

namespace App\Actions\V1\Fault;

use App\Http\Requests\Api\V1\StoreFaultRequest;
use App\Models\Fault;
use App\Models\User;
use App\Services\FaultService;

class ReportFaultAction
{
    public function __construct(private FaultService $service) {}

    public function execute(StoreFaultRequest $request, User $user): Fault
    {
        return $this->service->report($request, $user);
    }
}
