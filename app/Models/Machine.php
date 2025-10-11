<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function parts()
    {
        return $this->hasMany(MachinePart::class);
    }
}
