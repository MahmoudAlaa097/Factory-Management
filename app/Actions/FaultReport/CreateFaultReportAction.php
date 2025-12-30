<?php

namespace App\Actions\FaultReport;

use App\Models\FaultReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateFaultReportAction
{
    public function execute(array $data): FaultReport
    {
        try {
            return DB::transaction(function () use ($data) {
                return FaultReport::create([
                    'division_id' => $data['division_id'],
                    'machine_id' => $data['machine_id'],
                    'machine_section_id' => $data['machine_section_id'] ?? null,
                    'reported_by' => auth()->id(),
                    'reported_at' => now(),
                    'notes' => $data['description'],
                    'fault_type' => $data['fault_type'],
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Failed to create fault report', [
                'user_id' => auth()->id(),
                'data' => $data,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
