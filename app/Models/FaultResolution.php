<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultResolution extends Model
{
    protected $guarded = [];

    protected $casts = [
        'parts_used' => 'array',
    ];

    // Relationships
    public function faultReport()
    {
        return $this->belongsTo(FaultReport::class);
    }

    public function faultAssignment()
    {
        return $this->belongsTo(FaultAssignment::class);
    }

    public function machineComponent()
    {
        return $this->belongsTo(MachineComponent::class);
    }

    public function resolvedBy()
    {
        return $this->belongsTo(Employee::class, 'resolved_by');
    }
}
