<?php

namespace App\Livewire\Concerns;

use App\Services\MachineService;
use App\Services\MachineSectionService;
use Illuminate\Support\Facades\Log;

trait LoadsDependentData
{
    public $machines = [];
    public $sections = [];
    public $isLoadingMachines = false;
    public $isLoadingSections = false;

    protected function loadDependentData(
        string $type,
        callable $loader,
        string $property,
        string $autoSelectProperty,
        string $contextKey
    ) {
        $loadingProperty = "isLoading" . ucfirst($type);
        $this->$loadingProperty = true;
        $this->resetErrorBag($type);

        try {
            $items = $loader();
            $this->$property = $items->toArray();
            $this->autoSelectIfSingle($this->$property, $autoSelectProperty);
        } catch (\Exception $e) {
            $this->handleLoadError($type, $e, [$contextKey => $this->$contextKey]);
            $this->$property = [];
        } finally {
            $this->$loadingProperty = false;
        }
    }

    public function loadMachines()
    {
        $this->loadDependentData(
            'machines',
            fn() => app(MachineService::class)->getMachinesByDivision($this->division_id),
            'machines',
            'machine_id',
            'division_id'
        );
    }

    public function loadMachineSections()
    {
        $machineService = app(MachineService::class);
        $machine = $machineService->getMachineById($this->machine_id);

        if (!$machine?->machine_type_id) {
            $this->sections = [];
            return;
        }

        $this->loadDependentData(
            'sections',
            fn() => app(MachineSectionService::class)->getMachineSectionsByType($machine->machine_type_id),
            'sections',
            'machine_section_id',
            'machine_id'
        );
    }

    protected function autoSelectIfSingle(array $items, string $property)
    {
        if (count($items) === 1) {
            $this->$property = $items[0]['id'];
        }
    }

    protected function handleLoadError(string $field, \Exception $e, array $context = [])
    {
        Log::error("Failed to load {$field}", array_merge($context, [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'user_id' => auth()->id(),
        ]));

        $this->addError($field, "Unable to load {$field}. Please refresh and try again.");
    }
}
