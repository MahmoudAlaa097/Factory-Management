<?php

namespace App\DTOs\Reports;

class TechnicianTotalData
{
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly int    $faultMinutes,
        public readonly int    $preventiveMinutes,
        public readonly int    $taskMinutes,
        public readonly int    $totalMinutes,
    ) {}
}
