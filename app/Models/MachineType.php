<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineType extends Model
{
    protected $guarded = [];

    protected $casts = [
        'specifications' => 'array',
    ];

    // Relationships
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    public function machineSections()
    {
        return $this->belongsToMany(MachineSection::class, 'machine_type_machine_section');
    }
}
