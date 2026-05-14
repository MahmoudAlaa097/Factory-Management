<?php

namespace App\Events;

use App\Models\Fault;
use App\Enums\FaultStatus;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FaultStatusChanged implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Fault $fault,
        public readonly FaultStatus $oldStatus,
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("management.{$this->fault->maintenance_management_id}"),
            new PrivateChannel("division.{$this->fault->division_id}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'fault_id'   => $this->fault->id,
            'machine_id' => $this->fault->machine_id,
            'old_status' => $this->oldStatus->value,
            'new_status' => $this->fault->status->value,
        ];
    }

    public function broadcastAs(): string
    {
        return 'fault.status_changed';
    }
}
