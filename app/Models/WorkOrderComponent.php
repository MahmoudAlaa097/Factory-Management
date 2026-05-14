<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrderComponent extends Model
{
    protected $fillable = [
        'work_order_id',
        'machine_section_id',
        'machine_component_id',
    ];

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(MachineSection::class, 'machine_section_id');
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(MachineComponent::class, 'machine_component_id');
    }
}
