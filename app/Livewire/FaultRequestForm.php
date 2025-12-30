<?php

namespace App\Livewire;

use App\Actions\FaultReport\CreateFaultReportAction;
use App\Http\Requests\FaultReportRequest;
use App\Livewire\Concerns\HandlesCascadingSelects;
use App\Livewire\Concerns\LoadsDependentData;
use App\Services\DivisionService;
use Livewire\Component;

class FaultRequestForm extends Component
{
    // Traits
    use LoadsDependentData;
    use HandlesCascadingSelects;

    // Form fields
    public $division_id = '';
    public $machine_id = '';
    public $machine_section_id = '';
    public $fault_type = '';
    public $description = '';

    // Validation rules
    protected function rules()
    {
        return (new FaultReportRequest())->rules();
    }

    // Error messages
    protected function messages()
    {
        return (new FaultReportRequest())->messages();
    }

    // Initialize component
    public function mount()
    {
        $this->restoreOldInput();
        $this->loadInitialData();
    }

    // Form submission
    public function submit()
    {
        $validated = $this->validate();

        try {
            $action = app(\App\Actions\FaultReport\CreateFaultReportAction::class);
            $action->execute($validated);

            session()->flash('success', 'Fault report submitted successfully!');

            return redirect()->route('faults.index');
        } catch (\Exception $e) {
            dd($e->getMessage(), $e->getTraceAsString());
            $this->addError('submit', 'Unable to submit fault report.');
        }
    }

    public function render()
    {
        // Fetch production divisions
        $divisionService = app(DivisionService::class);

        // Render view with divisions
        return view('livewire.fault-request-form', [
            'productionDivisions' => $divisionService->getProductionDivisions(),
        ]);
    }
}
