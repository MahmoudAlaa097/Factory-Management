<?php

namespace App\Services;

use App\Models\Division;

class DivisionService
{
    public function getProductionDivisions()
    {
        return Division::production()->get();
    }
}
