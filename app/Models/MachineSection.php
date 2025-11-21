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
}
