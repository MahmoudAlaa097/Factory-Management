<?php

namespace App\Models;

use App\Enums\WorkOrderType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class WorkOrder extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'machine_id',
        'logged_by',
        'type',
        'date',
        'duration_minutes',
        'start_time',
        'end_time',
        'notes',
        'maintenance_type',
        'task_title',
        'task_tag',
        'requester_type',
        'requester_id',
    ];

    protected $casts = [
        'type'       => WorkOrderType::class,
        'date'       => 'date',
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
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

    public function requester(): MorphTo
    {
        return $this->morphTo();
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

    // ── Scopes ─────────────────────────────────────────────────

    public function scopeForDate(\Illuminate\Database\Eloquent\Builder $query, string $date): void
    {
        $query->whereDate('date', $date);
    }

    public function scopeForMonth(\Illuminate\Database\Eloquent\Builder $query, string $yearMonth): void
    {
        $query->whereRaw("TO_CHAR(date, 'YYYY-MM') = ?", [$yearMonth]);
    }

    public function scopeStartedFrom(\Illuminate\Database\Eloquent\Builder $query, string $date): void
    {
        $query->where('date', '>=', $date);
    }

    public function scopeStartedBefore(\Illuminate\Database\Eloquent\Builder $query, string $date): void
    {
        $query->where('date', '<=', $date);
    }
}
