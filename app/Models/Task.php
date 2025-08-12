<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function management()
    {
        return $this->division->management();
    }

    public function assingees()
    {
        return $this->belongsToMany(User::class, 'assigned_to');
    }

    public function assinger()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
