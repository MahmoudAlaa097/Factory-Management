<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    // Relationships

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function parentDivision()
    {
        return $this->belongsTo(Division::class, 'parent_division_id');
    }

    public function childDivisions()
    {
        return $this->hasMany(Division::class, 'parent_division_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }

    // Helpers
    public function isParent()
    {
        return is_null($this->parent_division_id);
    }

    public function isChild()
    {
        return !is_null($this->parent_division_id);
    }
}
