<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Contact;
use Illuminate\Validation\Rule;

class ContactForm extends Form
{
    public $id = null;

    public $name = null;
    public $description = null;
    public $email = null;
    public $logo = null;
    public $website = null;
    public $phone = null;

    // create a new record
    public function create()
    {
        $this->validate($this->rules());
        Contact::create([
            'name' => $this->name,
            'description' => $this->description,
            'email' => $this->email,
            'logo' => $this->logo,
            'website' => $this->website,
            'phone' => $this->phone,
            'active' => true
        ]);
    }

    // update record
    public function update(Contact $contact) {
        $this->validate($this->rules($contact->id));
        $contact->update([
            'name' => $this->name,
            'description' => $this->description,
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

    // Validation rules
    protected function rules($id = null)
    {
        return [
            'name' => ['required', Rule::unique('contacts', 'name')->ignore($id)],
            'description' => 'required|string',
            'email' => 'nullable|email',
            'logo' => 'nullable|url',
            'website' => 'nullable|url',
            'phone' => 'nullable|string',
        ];
    }
}

