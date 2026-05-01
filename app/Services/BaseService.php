<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

abstract class BaseService
{
    protected string $model;
    protected array $allowedIncludes = [];
    protected array $allowedFilters  = [];
    protected array $allowedSorts    = [];

    public function list(): never
    {
        throw new \LogicException(
            static::class . ': unscoped list() is forbidden. Use listForUser($user) instead.'
        );
    }

    public function show(Model $model): Model
    {
        return QueryBuilder::for($this->model)
            ->allowedIncludes($this->allowedIncludes)
            ->findOrFail($model->id);
    }

    protected function getAllowedFilters(): array
    {
        return array_map(
            fn($filter) => AllowedFilter::exact($filter),
            $this->allowedFilters
        );
    }
}
