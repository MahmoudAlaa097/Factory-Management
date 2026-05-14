<?php

namespace App\Events;

use App\Models\Fault;
use App\Models\Employee;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TechnicianUnassigned implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Fault $fault,
        public readonly Employee $technician,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("management.{$this->fault->maintenance_management_id}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'fault_id'       => $this->fault->id,
            'technician_id'  => $this->technician->id,
            'technician_name'=> $this->technician->name,
        ];
    }

    public function broadcastAs(): string
    {
        return 'technician.unassigned';
    }
}
