<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineDowntimeLog extends Model
{
    protected $guarded = [];

    protected $casts = [
        'downtime_start' => 'datetime',
        'downtime_end' => 'datetime',
    ];

    // Auto-calculate duration when downtime_end is set
    protected static function booted()
    {
        static::saving(function ($log) {
            if ($log->downtime_end && $log->downtime_start) {
                $log->duration_minutes = $log->downtime_start->diffInMinutes($log->downtime_end);
            }
        });
    }

    // Relationships
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function faultReport()
    {
        return $this->belongsTo(FaultReport::class);
    }

    // Helpers
    public function isOngoing()
    {
        return is_null($this->downtime_end);
    }

    public function getDurationHours()
    {
        return $this->duration_minutes ? round($this->duration_minutes / 60, 2) : null;
    }
}
