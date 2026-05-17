<?php

namespace App\Http\Resources\V1;

use App\DTOs\Reports\DailyReportData;
use App\DTOs\Reports\TechnicianTotalData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyReportResource extends JsonResource
{
    /**
     * @param DailyReportData $resource
     */
    public function toArray(Request $request): array
    {
        /** @var DailyReportData $report */
        $report = $this->resource;

        return [
            'header' => [
                'date'        => $report->date,
                'management'  => $report->management,
                'prepared_by' => $report->preparedBy,
            ],

            'sections' => [
                'faults' => [
                    'label'         => 'Faults',
                    'items'         => $report->faults,
                    'total_minutes' => $report->faults->sum('duration_minutes'),
                    'count'         => $report->faults->count(),
                ],
                'preventive' => [
                    'label'         => 'Preventive Maintenance',
                    'items'         => $report->preventive,
                    'total_minutes' => $report->preventive->sum('duration_minutes'),
                    'count'         => $report->preventive->count(),
                ],
                'tasks' => [
                    'label'  => 'Tasks',
                    'groups' => $report->tasks,   // already grouped by tag
                    'total_minutes' => $report->tasks->sum('total_minutes'),
                    'count'  => $report->tasks->sum(fn ($g) => count($g['items'])),
                ],
            ],

            'technician_totals' => $report->technicianTotals->map(fn (TechnicianTotalData $t) => [
                'id'                => $t->id,
                'name'              => $t->name,
                'fault_minutes'     => $t->faultMinutes,
                'preventive_minutes'=> $t->preventiveMinutes,
                'task_minutes'      => $t->taskMinutes,
                'total_minutes'     => $t->totalMinutes,
            ]),

            'summary' => [
                'total_duration_minutes' => $report->totalDurationMinutes,
                'fault_count'            => $report->faults->count(),
                'preventive_count'       => $report->preventive->count(),
                'task_count'             => $report->tasks->sum(fn ($g) => count($g['items'])),
            ],
        ];
    }
}
