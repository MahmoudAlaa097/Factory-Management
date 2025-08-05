<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $table = 'managements';

    protected $guarded = [];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'management_id');
    }

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Division::class);
    }
}
