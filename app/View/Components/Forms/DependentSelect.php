<?php

namespace App\View\Components\Forms;

use Illuminate\View\Component;

class DependentSelect extends Component
{
    public $label;
    public $name;
    public $wireModel;
    public $options;
    public $isLoading;
    public $required;
    public $placeholder;
    public $disabled;
    public $loadingMessage;
    public $emptyMessage;
    public $dependencyMessage;
    public $wireTarget;

    public function __construct(
        $label,
        $name,
        $wireModel,
        $options = [],
        $isLoading = false,
        $required = false,
        $placeholder = 'Select an option',
        $disabled = false,
        $loadingMessage = 'Loading...',
        $emptyMessage = 'No options available',
        $dependencyMessage = null,
        $wireTarget = null
    ) {
        $this->label = $label;
        $this->name = $name;
        $this->wireModel = $wireModel;
        $this->options = $options;
        $this->isLoading = $isLoading;
        $this->required = $required;
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
        $this->loadingMessage = $loadingMessage;
        $this->emptyMessage = $emptyMessage;
        $this->dependencyMessage = $dependencyMessage;
        $this->wireTarget = $wireTarget;
    }

    public function render()
    {
        return view('components.forms.dependent-select');
    }
}
