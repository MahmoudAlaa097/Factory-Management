<?php

namespace App\Services;

use App\Actions\V1\WorkOrder\AttachComponentsAction;
use App\Actions\V1\WorkOrder\AttachTechniciansAction;
use App\Actions\V1\WorkOrder\CreateWorkOrderAction;
use App\Enums\WorkOrderType;
use App\Models\WorkOrder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class WorkOrderService extends BaseService
{
    protected string $model = WorkOrder::class;

    protected array $allowedIncludes = [
        'machine',
        'loggedBy',
        'technicians',
        'components.section',
        'components.component',
        'requester',
    ];

    protected array $allowedFilters = [
        'type',
        'machine_id',
        'task_tag',
    ];

    protected array $allowedSorts = [
        'date',
        'duration_minutes',
        'created_at',
    ];

    public function __construct(
        private readonly CreateWorkOrderAction   $createWorkOrder,
        private readonly AttachTechniciansAction $attachTechnicians,
        private readonly AttachComponentsAction  $attachComponents,
    ) {}

    public function listWorkOrders(): LengthAwarePaginator
    {
        return QueryBuilder::for($this->model)
            ->allowedIncludes($this->allowedIncludes)
            ->allowedFilters([
                ...$this->getAllowedFilters(),
                AllowedFilter::exact('technician_id', 'technicians.id')->default(null),
                AllowedFilter::scope('from_date', 'startedFrom'),
                AllowedFilter::scope('to_date', 'startedBefore'),
            ])
            ->allowedSorts($this->allowedSorts)
            ->defaultSort('-date')
            ->paginate(20)
            ->appends(request()->query());
    }

    public function create(array $data): WorkOrder
    {
        return DB::transaction(function () use ($data) {
            $workOrder = $this->createWorkOrder->execute($data);

            $this->attachTechnicians->execute($workOrder, $data['technician_ids']);

            if ($data['type'] === WorkOrderType::Fault->value) {
                $this->attachComponents->execute($workOrder, $data['affected_components'] ?? []);
            }

            return $workOrder->load($this->allowedIncludes);
        });
    }

    public function distinctTags(): Collection
    {
        return WorkOrder::query()
            ->whereNotNull('task_tag')
            ->distinct()
            ->orderBy('task_tag')
            ->pluck('task_tag');
    }
}
