<?php

namespace App\Events;

use App\Models\Fault;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FaultCreated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Fault $fault) {}

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
            'division_id'=> $this->fault->division_id,
            'status'     => $this->fault->status->value,
            'reported_at'=> $this->fault->reported_at,
        ];
    }

    public function broadcastAs(): string
    {
        return 'fault.created';
    }
}
