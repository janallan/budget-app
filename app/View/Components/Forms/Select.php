<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $options = null,
        public $optionValueKey = null,
        public $optionLabelKey = null,
        public $hasEmptyOption = false,
        public $label = '',
        public $id = null,
    )
    {
        if (!$this->id) {
            $this->id = uuid();
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        return function (array $data) {
            // $data['componentName'];
            // $data['attributes'];
            // $data['slot'];

            $attributes = $data['attributes'];
            $error_key = $attributes->has('error_key') ? $attributes->get('error_key') : $this->id ;
            if ($error_key == $this->id) {
                if ($attributes->has('name')) $error_key = $attributes->get('name');

                else {
                    $wireModel = collect($attributes)->filter(function ($v, $k) {
                        return str_contains($k, 'wire:model');
                    })->first();

                    if ($wireModel) $error_key = $wireModel;
                }
            }

            return view('components.forms.select', compact('error_key'));
        };
    }
}
