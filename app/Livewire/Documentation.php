<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Documentation extends Component
{
    #[Layout('components.layout.servicepunt', ['title' => 'Informatie', 'description' => 'Informatie over deze app',])]
    public function render()
    {
        return view('livewire.documentation');
    }
}
