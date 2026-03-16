<?php

namespace App\Actions\V1\ComponentReplacement;

use App\Actions\V1\Base\BaseShowAction;
use App\Services\ComponentReplacementService;

class ShowComponentReplacementAction extends BaseShowAction
{
    public function __construct(private ComponentReplacementService $service) {}

    protected function service(): ComponentReplacementService
    {
        return $this->service;
    }
}
