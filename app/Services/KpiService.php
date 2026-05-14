<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class KpiService
{
    public function workOrderStats(Carbon $from, Carbon $to, ?int $machineId = null, ?string $type = null): array
    {
        return [
            'period'                  => $this->period($from, $to),
            'counts_by_type'          => $this->countsByType($from, $to, $machineId, $type),
            'avg_duration_by_type'    => $this->avgDurationByType($from, $to, $machineId, $type),
            'technician_workload'     => $this->technicianWorkload($from, $to, $machineId),
            'top_affected_components' => $this->topAffectedComponents($from, $to, $machineId),
            'per_machine'             => $this->perMachine($from, $to, $type),
        ];
    }

    // ── Private query methods ──────────────────────────────────

    private function period(Carbon $from, Carbon $to): array
    {
        return [
            'from' => $from->toDateString(),
            'to'   => $to->toDateString(),
        ];
    }

    private function countsByType(Carbon $from, Carbon $to, ?int $machineId, ?string $type): Collection
    {
        return DB::table('work_orders')
            ->whereNull('deleted_at')
            ->whereBetween('start_time', [$from, $to])
            ->when($machineId, fn ($q) => $q->where('machine_id', $machineId))
            ->when($type,      fn ($q) => $q->where('type', $type))
            ->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->pluck('total', 'type');
    }

    private function avgDurationByType(Carbon $from, Carbon $to, ?int $machineId, ?string $type): Collection
    {
        return DB::table('work_orders')
            ->whereNull('deleted_at')
            ->whereBetween('start_time', [$from, $to])
            ->whereNotNull('end_time')
            ->when($machineId, fn ($q) => $q->where('machine_id', $machineId))
            ->when($type,      fn ($q) => $q->where('type', $type))
            ->select(
                'type',
                DB::raw("ROUND(AVG(EXTRACT(EPOCH FROM (end_time - start_time)) / 60)::numeric, 1) as avg_minutes")
            )
            ->groupBy('type')
            ->pluck('avg_minutes', 'type');
    }

    private function technicianWorkload(Carbon $from, Carbon $to, ?int $machineId): Collection
    {
        return DB::table('work_order_technicians as wot')
            ->join('work_orders as wo', 'wo.id', '=', 'wot.work_order_id')
            ->join('employees as e', 'e.id', '=', 'wot.employee_id')
            ->whereNull('wo.deleted_at')
            ->whereBetween('wo.start_time', [$from, $to])
            ->when($machineId, fn ($q) => $q->where('wo.machine_id', $machineId))
            ->select(
                'e.id',
                'e.name',
                'e.code',
                DB::raw('count(wot.work_order_id) as total_orders'),
                DB::raw("ROUND(SUM(EXTRACT(EPOCH FROM (wo.end_time - wo.start_time)) / 60)::numeric, 1) as total_minutes")
            )
            ->groupBy('e.id', 'e.name', 'e.code')
            ->orderByDesc('total_orders')
            ->get();
    }

    private function topAffectedComponents(Carbon $from, Carbon $to, ?int $machineId): Collection
    {
        return DB::table('work_order_components as woc')
            ->join('work_orders as wo', 'wo.id', '=', 'woc.work_order_id')
            ->join('machine_sections as ms', 'ms.id', '=', 'woc.machine_section_id')
            ->join('machine_components as mc', 'mc.id', '=', 'woc.machine_component_id')
            ->whereNull('wo.deleted_at')
            ->where('wo.type', 'fault')
            ->whereBetween('wo.start_time', [$from, $to])
            ->when($machineId, fn ($q) => $q->where('wo.machine_id', $machineId))
            ->select(
                'ms.id as section_id',
                'ms.name as section',
                'mc.id as component_id',
                'mc.name as component',
                DB::raw('count(*) as occurrences')
            )
            ->groupBy('ms.id', 'ms.name', 'mc.id', 'mc.name')
            ->orderByDesc('occurrences')
            ->limit(10)
            ->get();
    }

    private function perMachine(Carbon $from, Carbon $to, ?string $type): Collection
    {
        return DB::table('work_orders as wo')
            ->join('machines as m', 'm.id', '=', 'wo.machine_id')
            ->whereNull('wo.deleted_at')
            ->whereBetween('wo.start_time', [$from, $to])
            ->when($type, fn ($q) => $q->where('wo.type', $type))
            ->select(
                'm.id',
                'm.number',
                DB::raw('count(*) as total_orders'),
                DB::raw("SUM(CASE WHEN wo.type = 'fault'      THEN 1 ELSE 0 END) as fault_count"),
                DB::raw("SUM(CASE WHEN wo.type = 'preventive' THEN 1 ELSE 0 END) as preventive_count"),
                DB::raw("SUM(CASE WHEN wo.type = 'task'       THEN 1 ELSE 0 END) as task_count")
            )
            ->groupBy('m.id', 'm.number')
            ->orderByDesc('total_orders')
            ->get();
    }
}
