<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaultAssignment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'assigned_at' => 'datetime',
        'acknowledged_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function faultReport()
    {
        return $this->belongsTo(FaultReport::class);
    }

    public function assignedToManagement()
    {
        return $this->belongsTo(Management::class, 'assigned_to_management_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(Employee::class, 'assigned_by');
    }

    public function resolution()
    {
        return $this->hasOne(FaultResolution::class);
    }

    // Helpers
    public function isCompleted()
    {
        return !is_null($this->completed_at);
    }

    public function isInProgress()
    {
        return !is_null($this->started_at) && is_null($this->completed_at);
    }

    public function isPending()
    {
        return is_null($this->acknowledged_at);
    }
}
