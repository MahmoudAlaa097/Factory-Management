<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $table = 'managements';

    protected $guarded = [];

    // Relationships
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function manager()
    {
        return $this->hasOne(Employee::class)->managers();
    }
}
