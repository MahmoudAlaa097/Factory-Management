<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    protected $guarded = [];

    protected $casts = [
        'last_maintenance_date' => 'date',
    ];

    // Status constants
    public const STATUS_OPERATIONAL = 'operational';
    public const STATUS_FAULTY = 'faulty';
    public const STATUS_UNDER_MAINTENANCE = 'under_maintenance';
    public const STATUS_DECOMMISSIONED = 'decommissioned';
    public const STATUS_IDLE = 'idle';

    public const STATUSES = [
        self::STATUS_OPERATIONAL => 'Operational',
        self::STATUS_FAULTY => 'Faulty',
        self::STATUS_UNDER_MAINTENANCE => 'Under Maintenance',
        self::STATUS_DECOMMISSIONED => 'Decommissioned',
        self::STATUS_IDLE => 'Idle',
    ];

    // Auto-sync division_id from machine_type
    protected static function booted()
    {
        static::saving(function ($machine) {
            if ($machine->machine_type_id && !$machine->division_id) {
                $machine->division_id = MachineType::find($machine->machine_type_id)->division_id;
            }
        });
    }

    // Relationships
    public function machineType()
    {
        return $this->belongsTo(MachineType::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Scopes
    public function scopeOperational($query)
    {
        return $query->where('status', self::STATUS_OPERATIONAL);
    }

    public function scopeFaulty($query)
    {
        return $query->where('status', self::STATUS_FAULTY);
    }

    public function scopeUnderMaintenance($query)
    {
        return $query->where('status', self::STATUS_UNDER_MAINTENANCE);
    }

    public function scopeDecommissioned($query)
    {
        return $query->where('status', self::STATUS_DECOMMISSIONED);
    }

    public function scopeIdle($query)
    {
        return $query->where('status', self::STATUS_IDLE);
    }

    // Helpers
    public static function getStatusValidationRule()
    {
        return 'required|in:' . implode(',', array_keys(self::STATUSES));
    }

    public function getStatusDisplayName()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
