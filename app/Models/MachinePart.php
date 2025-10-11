<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachinePart extends Model
{
    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function malfunctions()
    {
        return $this->hasMany(MachineMalfunction::class, 'part_id');
    }
}
