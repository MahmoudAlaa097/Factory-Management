<?php

namespace App\Actions\V1\ComponentReplacement;

use App\Actions\V1\Base\BaseListAction;
use App\Services\ComponentReplacementService;

class ListComponentReplacementsAction extends BaseListAction
{
    public function __construct(private ComponentReplacementService $service) {}

    protected function service(): ComponentReplacementService
    {
        return $this->service;
    }
}
