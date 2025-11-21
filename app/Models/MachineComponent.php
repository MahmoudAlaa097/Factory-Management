<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineComponent extends Model
{
    protected $guarded = [];

    // Type constants
    public const TYPE_ELECTRICAL = 'electrical';
    public const TYPE_MECHANICAL = 'mechanical';

    public const TYPES = [
        self::TYPE_ELECTRICAL => 'Electrical',
        self::TYPE_MECHANICAL => 'Mechanical',
    ];

    public function machineSection()
    {
        return $this->belongsTo(MachineSection::class);
    }

    public function componentType()
    {
        return $this->belongsTo(ComponentType::class);
    }

    // Scopes
    public function scopeElectrical($query)
    {
        return $query->whereHas('componentType', function ($q) {
            $q->where('maintenance_type', self::TYPE_ELECTRICAL);
        });
    }

    public function scopeMechanical($query)
    {
        return $query->whereHas('componentType', function ($q) {
            $q->where('maintenance_type', self::TYPE_MECHANICAL);
        });
    }
}
