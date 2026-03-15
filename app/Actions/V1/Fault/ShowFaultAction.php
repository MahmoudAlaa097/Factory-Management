<?php

namespace App\Actions\V1\Fault;

use App\Actions\V1\Base\BaseShowAction;
use App\Services\FaultService;

class ShowFaultAction extends BaseShowAction
{
    public function __construct(private FaultService $service) {}

    protected function service(): FaultService
    {
        return $this->service;
    }
}
