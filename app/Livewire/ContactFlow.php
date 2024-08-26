<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layout.contactflow', ['title' => 'Contact Flow', 'description' => 'Contact flow van het Servicepunt',])]
class ContactFlow extends Component
{
    public function render()
    {
        return view('livewire.contact-flow');
    }
}
