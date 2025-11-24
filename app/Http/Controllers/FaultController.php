<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DivisionService;
use App\Services\MachineService;

class FaultController extends Controller
{
    public function create(DivisionService $divisionService)
    {
        // Get production divisions
        $productionDivisions = $divisionService->getProductionDivisions();

        return view('fault.create', compact('productionDivisions'));
    }

    /**
     * Return machines for a given division (used by AlpineJS).
     */
    public function getMachinesByDivision(Request $request)
    {
        // Validate input
        $request->validate([
            'division_id' => 'required|exists:divisions,id',
        ]);

        // Get machines for the division
        $machineService = new MachineService();
        $machines = $machineService->getMachinesByDivision($request->division_id);

        return response()->json($machines);
    }
}
