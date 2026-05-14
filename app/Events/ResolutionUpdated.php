<?php

namespace App\Events;

use App\Models\Fault;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ResolutionUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Fault $fault) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel("management.{$this->fault->maintenance_management_id}"),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'fault_id'         => $this->fault->id,
            'resolution_notes' => $this->fault->resolution_notes,
            'time_consumed'    => $this->fault->time_consumed,
        ];
    }

    public function broadcastAs(): string
    {
        return 'fault.resolution_updated';
    }
}
