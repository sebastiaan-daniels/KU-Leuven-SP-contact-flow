<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Contacts extends Component
{
    #[Layout('components.layout.servicepunt', ['title' => 'Contacten', 'description' => 'Beheer de contacten',])]
    public function render()
    {
        return view('livewire.user.contacts');
    }
}
