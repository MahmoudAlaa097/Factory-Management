    <?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use App\Models\Division;
    use App\Models\Machine;
    use App\Models\User;
    use App\Models\MachinePart;
    use App\Models\MachineMalfunction;


    class FixingRequestController extends Controller
    {
        public function create()
        {
            // Fetch all divisions
            $divisions = Division::select('id as value', 'name')
                ->get()
                ->toArray();

            // Preappend a default option
            array_unshift($divisions, ['value' => '', 'name' => 'Select Division']);

            // Fetch all machines
            $machines = Machine::select('id as value', 'number')
                ->get()
                ->toArray();

            // Preappend a default option
            array_unshift($machines, ['value' => '', 'name' => 'Select Machine']);

            // Fetch all technicians
            $technicians = User::select('id as value', 'name')
                ->where('role', 'technician')
                ->get()
                ->toArray();

            // Preappend a default option
            array_unshift($technicians, ['value' => '', 'name' => 'Select Technician']);

            // Fetch all machine parts
            $machine_parts = MachinePart::select('id as value', 'part')
                ->get()
                ->toArray();

            // Preappend a default option
            array_unshift($machine_parts, ['value' => '', 'name' => 'Select Machine Part']);

            // Fetch all machine malfunctions
            $machine_malfunctions = MachineMalfunction::select('id as value', 'malfunction')
                ->get()
                ->toArray();

            // Preappend a default option
            array_unshift($machine_malfunctions, ['value' => '', 'name' => 'Select Machine Malfunction']);

            // Pass data to the view
            return view('fixing.create', compact('divisions', 'machines', 'technicians', 'machine_parts', 'machine_malfunctions'));
        }
    }
