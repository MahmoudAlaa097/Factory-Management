<?php

namespace App\Actions\V1\ComponentReplacement;

use App\Http\Requests\Api\V1\StoreComponentReplacementRequest;
use App\Models\ComponentReplacement;
use App\Models\Fault;
use App\Models\User;
use App\Services\ComponentReplacementService;

class LogComponentReplacementAction
{
    public function __construct(private ComponentReplacementService $service) {}

    public function execute(StoreComponentReplacementRequest $request, Fault $fault, User $user): ComponentReplacement
    {
        return $this->service->log($request, $fault, $user);
    }
}
