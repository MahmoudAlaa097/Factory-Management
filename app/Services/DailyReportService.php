<?php

namespace App\Services;

use App\DTOs\Reports\DailyReportData;
use App\DTOs\Reports\TechnicianTotalData;
use App\Enums\WorkOrderType;
use App\Models\Management;
use App\Models\WorkOrder;
use Illuminate\Support\Collection;

class DailyReportService
{
    public function build(string $date, Management $management, string $preparedBy): DailyReportData
    {
        $workOrders = $this->fetchWorkOrders($date, $management);

        $faults     = $workOrders->where('type', WorkOrderType::Fault);
        $preventive = $workOrders->where('type', WorkOrderType::Preventive);
        $tasks      = $workOrders->where('type', WorkOrderType::Task);

        return new DailyReportData(
            date:                 $date,
            management:           $management->type->value,
            preparedBy:           $preparedBy,
            faults:               $this->formatFaults($faults),
            preventive:           $this->formatPreventive($preventive),
            tasks:                $this->formatTasks($tasks),
            technicianTotals:     $this->buildTechnicianTotals($faults, $preventive, $tasks),
            totalDurationMinutes: $workOrders->sum('duration_minutes'),
        );
    }

    // ── Private ────────────────────────────────────────────────

    private function fetchWorkOrders(string $date, Management $management): Collection
    {
        return WorkOrder::query()
            ->with([
                'machine',
                'technicians',
                'components.section',
                'components.component',
                'requester',
            ])
            ->whereDate('date', $date)
            ->whereHas('technicians', function ($q) use ($management) {
                $q->where('management_id', $management->id);
            })
            ->get();
    }

    private function formatFaults(Collection $faults): Collection
    {
        return $faults->map(fn (WorkOrder $wo) => [
            'machine'          => $wo->machine ? "Machine #{$wo->machine->number}" : '—',
            'technicians'      => $wo->technicians->pluck('name')->join(', '),
            'duration_minutes' => $wo->duration_minutes,
            'components'       => $wo->components->map(fn ($c) => [
                'section'   => $c->section->name,
                'component' => $c->component->name,
            ]),
            'notes'            => $wo->notes,
        ])->values();
    }

    private function formatPreventive(Collection $preventive): Collection
    {
        return $preventive->map(fn (WorkOrder $wo) => [
            'machine'          => $wo->machine ? "Machine #{$wo->machine->number}" : '—',
            'maintenance_type' => $wo->maintenance_type,
            'technicians'      => $wo->technicians->pluck('name')->join(', '),
            'duration_minutes' => $wo->duration_minutes,
            'notes'            => $wo->notes,
        ])->values();
    }

    private function formatTasks(Collection $tasks): Collection
    {
        // Group by task_tag — ungrouped tasks go under 'other'
        return $tasks
            ->groupBy(fn (WorkOrder $wo) => $wo->task_tag ?? 'other')
            ->map(fn (Collection $group, string $tag) => [
                'tag'   => $tag,
                'items' => $group->map(fn (WorkOrder $wo) => [
                    'title'            => $wo->task_title,
                    'requester'        => $this->formatRequester($wo),
                    'technicians'      => $wo->technicians->pluck('name')->join(', '),
                    'duration_minutes' => $wo->duration_minutes,
                    'notes'            => $wo->notes,
                ])->values(),
                'total_minutes' => $group->sum('duration_minutes'),
            ])
            ->values();
    }

    private function formatRequester(WorkOrder $wo): ?string
    {
        if (! $wo->requester) return null;

        $type = class_basename($wo->requester_type);
        $name = $wo->requester->name ?? $wo->requester->type ?? '—';

        return "{$type}: {$name}";
    }

    private function buildTechnicianTotals(
        Collection $faults,
        Collection $preventive,
        Collection $tasks,
    ): Collection {
        // Collect all technician appearances per type with their duration
        $map = [];

        $this->accumulateTechnicians($map, $faults,     'fault');
        $this->accumulateTechnicians($map, $preventive, 'preventive');
        $this->accumulateTechnicians($map, $tasks,      'task');

        return collect($map)
            ->map(fn (array $data, int $id) => new TechnicianTotalData(
                id:                 $id,
                name:               $data['name'],
                faultMinutes:       $data['fault']      ?? 0,
                preventiveMinutes:  $data['preventive'] ?? 0,
                taskMinutes:        $data['task']        ?? 0,
                totalMinutes:       ($data['fault'] ?? 0) + ($data['preventive'] ?? 0) + ($data['task'] ?? 0),
            ))
            ->sortByDesc('totalMinutes')
            ->values();
    }

    private function accumulateTechnicians(array &$map, Collection $workOrders, string $type): void
    {
        foreach ($workOrders as $wo) {
            foreach ($wo->technicians as $tech) {
                if (! isset($map[$tech->id])) {
                    $map[$tech->id] = ['name' => $tech->name, 'fault' => 0, 'preventive' => 0, 'task' => 0];
                }
                // Duration is split equally among technicians on the same work order
                $split = (int) round($wo->duration_minutes / max(1, $wo->technicians->count()));
                $map[$tech->id][$type] += $split;
            }
        }
    }
}
