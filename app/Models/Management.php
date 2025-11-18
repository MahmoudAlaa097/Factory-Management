<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Management extends Model
{
    protected $table = 'managements';

    protected $guarded = [];

    // Type constants
    public const TYPE_PRODUCTION = 'production';
    public const TYPE_MAINTENANCE = 'maintenance';

    public const TYPES = [
        self::TYPE_PRODUCTION => 'Production',
        self::TYPE_MAINTENANCE => 'Maintenance',
    ];

    // Relationships
    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Get manager as relationship (can be eager loaded)
    public function manager()
    {
        return $this->hasOne(Employee::class)->managers();
    }

    // Scopes
    public function scopeProduction($query)
    {
        return $query->where('type', self::TYPE_PRODUCTION);
    }

    public function scopeMaintenance($query)
    {
        return $query->where('type', self::TYPE_MAINTENANCE);
    }

    // Helper methods
    public static function getValidationRule()
    {
        return 'required|in:' . implode(',', array_keys(self::TYPES));
    }

    public function getTypeDisplayName()
    {
        return self::TYPES[$this->type] ?? $this->type;
    }
}
