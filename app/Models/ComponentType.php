<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComponentType extends Model
{
    protected $guarded = [];

    public function machineComponents()
    {
        return $this->hasMany(MachineComponent::class);
    }
}
