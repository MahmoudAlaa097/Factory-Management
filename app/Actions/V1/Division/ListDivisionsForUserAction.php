<?php

namespace App\Actions\V1\Division;

use App\Models\User;
use App\Services\DivisionService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListDivisionsForUserAction
{
    public function __construct(private DivisionService $service) {}

    public function execute(User $user): LengthAwarePaginator
    {
        return $this->service->listForUser($user);
    }
}
