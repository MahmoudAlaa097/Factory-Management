<?php

namespace App\Events;

use App\Models\Fault;
use App\Models\FaultComponent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class FaultComponentDetached implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly Fault $fault,
        public readonly FaultComponent $faultComponent,
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
            'fault_id'             => $this->fault->id,
            'fault_component_id'   => $this->faultComponent->id,
            'machine_component_id' => $this->faultComponent->machine_component_id,
        ];
    }

    public function broadcastAs(): string
    {
        return 'fault.component_detached';
    }
}
