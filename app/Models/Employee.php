<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function management()
    {
        return $this->belongsTo(Management::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    // Scopes
    public function scopePosition($query, string $position)
    {
        return $query->where('position', $position);
    }

    public function scopeTechnicians($query)
    {
        return $query->position('technician');
    }

    public function scopeEngineers($query)
    {
        return $query->position('engineer');
    }

    public function scopeManagers($query)
    {
        return $query->position('manager');
    }

    public function scopeOperators($query)
    {
        return $query->position('operator');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('user', function($q) {
            $q->whereNotNull('id');
        });
    }
}
