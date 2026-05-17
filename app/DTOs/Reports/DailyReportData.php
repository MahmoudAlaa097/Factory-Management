<?php

namespace App\DTOs\Reports;

use Illuminate\Support\Collection;

class DailyReportData
{
    public function __construct(
        public readonly string     $date,
        public readonly string     $management,
        public readonly string     $preparedBy,
        public readonly Collection $faults,
        public readonly Collection $preventive,
        public readonly Collection $tasks,        // grouped by task_tag
        public readonly Collection $technicianTotals,
        public readonly int        $totalDurationMinutes,
    ) {}
}
