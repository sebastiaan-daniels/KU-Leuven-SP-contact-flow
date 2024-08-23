<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Contact;
use Illuminate\Support\Facades\Storage;

class ContactForm extends Form
{
    public $id = null;

    #[Validate('required|unique:contacts,name')]
    public $name = null;

    public $email= null;

    public $logo = null;
    public $website= null;
    public $phone= null;


    // create a new record
    public function create()
    {
        $this->validate();
        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo,
            'website' => $this->website,
            'phone' => $this->phone,
            'active' => true
        ]);
    }

    // update record
    public function update(Contact $contact) {
        $this->validate();
        $contact->update([
            'name' => $this->name,
            'email' => $this->email,
            'logo' => $this->logo,
            'website' => $this->website,
            'phone' => $this->phone,
        ]);
    }

    // delete the selected record
    public function delete(Contact $contact)
    {
        $contact->delete();
    }
}
