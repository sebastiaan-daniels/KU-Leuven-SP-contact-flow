<?php

namespace App\Livewire\User;

use App\Livewire\Forms\ContactForm;
use App\Models\Contact;
use Livewire\Component;
use Livewire\Attributes\Layout;

class Contacts extends Component
{

    public $search;
    public $active = true;
    public $loading = 'Even geduld...';
    public $perPage = 5;

    public $showModal = false;

    public $orderBy = 'name';
    public $orderAsc = true;
    public $showConfirmation = false;
    public ContactForm $form;

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }
    public function newContact()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createContact()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het contact <b><i>{$this->form->name}</i></b> is aangemaakt!",
            'icon' => 'success',
        ]);
    }

    public function updateContact(Contact $contact)
    {
        $this->form->update($contact);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het contact <b><i>{$this->form->name}</i></b> is geüpdated",
            'icon' => 'success',
        ]);
    }

    public function editContact(Contact $contact)
    {
        $this->resetErrorBag();
        $this->form->fill($contact);
        $this->showModal = true;
    }

    public function confirmation (Contact $contact)
    {
        $this->form->reset();
        $this->form->fill($contact);
        $this->resetErrorBag();
        $this->showConfirmation = true;
    }

    public function deleteRecord(Contact $contact)
    {
        $this->form->delete($contact);
        $this->showConfirmation = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "Het contact <b><i>{$contact->name}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }

    #[Layout('components.layout.servicepunt', ['title' => 'Contacten', 'description' => 'Beheer de contacten',])]
    public function render()
    {
        $query = Contact::searchName($this->search);
        if (!$this->active)
            $query->where('active', false);
        else
            $query->where('active', true);
        $contacts =
            $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        //$contacts = Contact::all();

        return view('livewire.user.contacts', compact('contacts'));

    }
}
