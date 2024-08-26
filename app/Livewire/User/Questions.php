<?php

namespace App\Livewire\User;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Questions extends Component
{
    #[Layout('components.layout.servicepunt', ['title' => 'Vragen beheren', 'description' => 'Beheer de vragen van de contact flow',])]
    public function render()
    {
        return view('livewire.user.questions');
    }
}
