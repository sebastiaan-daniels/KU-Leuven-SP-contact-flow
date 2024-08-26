<?php

namespace App\Livewire\User;

use App\Models\Contact;
use App\Models\Question;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Livewire\Forms\QuestionForm;

class Questions extends Component
{

    public $search;
    public $active = true;
    public $loading = 'Even geduld...';
    public $perPage = 10;

    public $showModal = false;

    public $orderBy = 'id';
    public $orderAsc = true;
    public $showConfirmation = false;
    public QuestionForm $form;

    public function fetchContactFromId($id)
    {
        return Contact::find($id);
    }

    public function fetchNonEndingQuestions()
    {
        return Question::whereNotNull('child_question')->get();
    }
    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }
    public function newQuestion()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }

    public function createQuestion()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De vraag <b><i>{$this->form->name}</i></b> is aangemaakt!",
            'icon' => 'success',
        ]);
    }

    public function updateQuestion(Question $question)
    {
        $this->form->update($question);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De vraag <b><i>{$this->form->name}</i></b> is geüpdated",
            'icon' => 'success',
        ]);
    }

    public function editQuestion(Question $question)
    {
        $this->resetErrorBag();
        $this->form->fill($question);
        $this->showModal = true;
    }

    public function confirmation (Question $question)
    {
        $this->form->reset();
        $this->form->fill($question);
        $this->resetErrorBag();
        $this->showConfirmation = true;
    }

    public function deleteRecord(Question $question)
    {
        $this->form->delete($question);
        $this->showConfirmation = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De vraag <b><i>{$question->name}</i></b> is verwijderd",
            'icon' => 'success',
        ]);
    }
    #[Layout('components.layout.servicepunt', ['title' => 'Vragen beheren', 'description' => 'Beheer de vragen van de contact flow',])]
    public function render()
    {
        $contacts = Contact::all();
        $query = Question::searchName($this->search);
        if (!$this->active)
            $query->where('active', false);
        else
            $query->where('active', true);
        $questions = $query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);

        return view('livewire.user.questions', compact('questions', 'contacts'));
    }
}
