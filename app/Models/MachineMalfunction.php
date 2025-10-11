<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MachineMalfunction extends Model
{
    public function part()
    {
        return $this->belongsTo(MachinePart::class, 'part_id');
    }
}
