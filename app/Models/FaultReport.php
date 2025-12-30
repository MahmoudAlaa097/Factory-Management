<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FaultReport extends Model
{
    protected $guarded = [];

    protected $casts = [
        'reported_at' => 'datetime',
        'machine_stopped' => 'boolean',
    ];

    // Fault type constants
    public const TYPE_ELECTRICAL = 'electrical';
    public const TYPE_MECHANICAL = 'mechanical';
    public const TYPE_BOTH = 'both';
    public const TYPE_OTHER = 'other';

    public const TYPES = [
        self::TYPE_ELECTRICAL => 'Electrical',
        self::TYPE_MECHANICAL => 'Mechanical',
        self::TYPE_BOTH => 'Both (Electrical & Mechanical)',
        self::TYPE_OTHER => 'Other',
    ];

    // Status constants
    public const STATUS_PENDING = 'pending';
    public const STATUS_ASSIGNED = 'assigned';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_RESOLVED = 'resolved';
    public const STATUS_CANCELLED = 'cancelled';

    public const STATUSES = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_ASSIGNED => 'Assigned',
        self::STATUS_IN_PROGRESS => 'In Progress',
        self::STATUS_RESOLVED => 'Resolved',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    // Auto-generate report number and set priority
    protected static function booted()
    {
        static::creating(function ($faultReport) {
            DB::transaction(function () use ($faultReport) {
                $year = now()->year;

                $lastReport = self::where('report_number', 'LIKE', $year . '-%')
                    ->lockForUpdate()
                    ->latest('id')
                    ->first();

                $nextNumber = $lastReport
                    ? intval(explode('-', $lastReport->report_number)[1]) + 1
                    : 1;

                $faultReport->report_number = $year . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
                $faultReport->priority = $faultReport->machine_stopped ? 'critical' : 'normal';
            });
        });
    }

    // Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function machineSection()
    {
        return $this->belongsTo(MachineSection::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(Employee::class, 'reported_by');
    }

    public function assignments()
    {
        return $this->hasMany(FaultAssignment::class);
    }

    public function resolutions()
    {
        return $this->hasMany(FaultResolution::class);
    }

    public function downtimeLog()
    {
        return $this->hasOne(MachineDowntimeLog::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeAssigned($query)
    {
        return $query->where('status', self::STATUS_ASSIGNED);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', self::STATUS_IN_PROGRESS);
    }

    public function scopeResolved($query)
    {
        return $query->where('status', self::STATUS_RESOLVED);
    }

    public function scopeCritical($query)
    {
        return $query->where('priority', 'critical');
    }

    public function scopeElectrical($query)
    {
        return $query->whereIn('fault_type', [self::TYPE_ELECTRICAL, self::TYPE_BOTH]);
    }

    public function scopeMechanical($query)
    {
        return $query->whereIn('fault_type', [self::TYPE_MECHANICAL, self::TYPE_BOTH]);
    }

    // Helpers
    public function isResolved()
    {
        return $this->status === self::STATUS_RESOLVED;
    }

    public function isCritical()
    {
        return $this->priority === 'critical';
    }

    public function getTypeDisplayName()
    {
        return self::TYPES[$this->fault_type] ?? $this->fault_type;
    }

    public function getStatusDisplayName()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
