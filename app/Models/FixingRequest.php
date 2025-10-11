<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixingRequest extends Model
{
    public $guarded = [];

    protected $casts = [
        'requested_at' => 'datetime',
        'received_at' => 'datetime',
        'fixed_at' => 'datetime',
        'closed_at' => 'datetime',
        'confirmed_by_operator' => 'boolean',
        'ack_supervisor' => 'boolean',
        'ack_engineer' => 'boolean',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function part()
    {
        return $this->belongsTo(MachinePart::class, 'part_id');
    }

    public function malfunction()
    {
        return $this->belongsTo(MachineMalfunction::class, 'malfunction_id');
    }

    public function getTimeTakenAttribute()
    {
        if (!$this->requested_at || !$this->fixed_at) {
            return null;
        }

        return $this->requested_at->diffInMinutes($this->fixed_at);
    }
}
