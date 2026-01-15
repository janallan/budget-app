<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Loading extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        // Optional: limit the loader to specific Livewire actions/props (e.g. "save" or "search")
        public $target = null,

        // Text under the spinner
        public $text = 'Loading...',

        // Optional: add extra classes (e.g. "bg-black/40")
        public $class = 'bg-white/70',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.loading');
    }
}
