<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Date;
use Illuminate\View\Component;

class ProjectLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $activeTab,
        public array $urls
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.project-layout');
    }
}
