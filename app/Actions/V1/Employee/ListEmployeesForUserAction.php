<?php

namespace App\Actions\V1\Employee;

use App\Models\User;
use App\Services\EmployeeService;
use Illuminate\Pagination\LengthAwarePaginator;

class ListEmployeesForUserAction
{
    public function __construct(private EmployeeService $service) {}

    public function execute(User $user): LengthAwarePaginator
    {
        return $this->service->listForUser($user);
    }
}
