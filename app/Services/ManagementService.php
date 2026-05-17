<?php

namespace App\Services;

use App\Models\Management;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class ManagementService extends BaseService
{
    protected string $model          = Management::class;
    protected array $allowedIncludes = ['divisions', 'employees'];
    protected array $allowedSorts    = ['id', 'name', 'type'];

    /**
     * All users can see all managements — no scoping needed.
     */
    public function listForUser(User $user): LengthAwarePaginator
    {
        return QueryBuilder::for(Management::class)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedSorts($this->allowedSorts)
            ->paginate(request('per_page', 15));
    }
}
