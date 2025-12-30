<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineSection extends Model
{
    protected $guarded = [];

    public function components()
    {
        return $this->hasMany(MachineComponent::class);
    }

    public function machineTypes()
    {
        return $this->belongsToMany(MachineType::class, 'machine_type_machine_section');
    }

    // Scopes
    public function scopeMachineType($query, int $machineTypeId)
    {
        return $query->whereHas('machineTypes', function ($q) use ($machineTypeId) {
            $q->where('machine_type_id', $machineTypeId);
        });
    }
}
