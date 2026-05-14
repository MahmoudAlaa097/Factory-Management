<?php

namespace App\Models;

use App\Enums\WorkOrderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'machine_id',
        'logged_by',
        'type',
        'start_time',
        'end_time',
        'notes',
        // preventive
        'maintenance_type',
        'is_finished',
        // task
        'task_title',
        'division_id',
    ];

    protected $casts = [
        'type'       => WorkOrderType::class,
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
        'is_finished' => 'boolean',
    ];

    // ── Relationships ──────────────────────────────────────────

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function loggedBy(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'logged_by');
    }

    public function division(): BelongsTo
    {
        return $this->belongsTo(Division::class);
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'work_order_technicians')
                    ->withTimestamps();
    }

    public function components(): HasMany
    {
        return $this->hasMany(WorkOrderComponent::class);
    }

    // ── Scopes (used by Spatie QueryBuilder AllowedFilter::scope) ─

    public function scopeStartedFrom(\Illuminate\Database\Eloquent\Builder $query, string $date): void
    {
        $query->where('start_time', '>=', $date);
    }

    public function scopeStartedBefore(\Illuminate\Database\Eloquent\Builder $query, string $date): void
    {
        $query->where('start_time', '<=', $date);
    }

    // ── Computed ───────────────────────────────────────────────

    /**
     * Duration in minutes between start_time and end_time.
     */
    public function getDurationMinutesAttribute(): ?int
    {
        if (! $this->end_time) {
            return null;
        }

        return (int) $this->start_time->diffInMinutes($this->end_time);
    }
}
