<?php

namespace App\Actions\V1\Machine;

use App\Models\User;
use App\Services\MachineService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListMachinesForUserAction
{
    public function __construct(private MachineService $service) {}

    public function execute(User $user): LengthAwarePaginator
    {
        return $this->service->listForUser($user);
    }
}
