<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Machine;

class TestController extends Controller
{
    public function byDivision(Request $request)
    {
        $divisionId = $request->query('division_id');

        if (!$divisionId) {
            return response()->json([]);
        }

        $machines = Machine::where('division_id', $divisionId)
            ->orderBy('number')
            ->get(['id', 'number']); // only return id and number

        return response()->json($machines);
    }
}
