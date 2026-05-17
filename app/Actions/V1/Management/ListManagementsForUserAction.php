<?php

namespace App\Actions\V1\Management;

use App\Models\User;
use App\Services\ManagementService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListManagementsForUserAction
{
    public function __construct(private ManagementService $service) {}

    public function execute(User $user): LengthAwarePaginator
    {
        return $this->service->listForUser($user);
    }
}
