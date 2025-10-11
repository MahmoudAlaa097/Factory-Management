<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'division_id');
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}
