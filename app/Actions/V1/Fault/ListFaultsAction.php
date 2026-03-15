<?php

namespace App\Actions\V1\Fault;

use App\Models\User;
use App\Services\FaultService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListFaultsAction
{
    public function __construct(private FaultService $service) {}

    public function execute(User $user): LengthAwarePaginator
    {
        return $this->service->listForUser($user);
    }
}
