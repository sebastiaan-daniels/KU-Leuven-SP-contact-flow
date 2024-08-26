<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Question;
use App\Models\Contact;

#[Layout('components.layout.contactflow', ['title' => 'Contact Flow', 'description' => 'Contact flow van het Servicepunt',])]
class ContactFlow extends Component
{
    public $loading = 'Even geduld...';
    public $currentQuestion = 1;

    public function fetchCurrentQuestionById($id)
    {
        return Question::find($id);
    }
    public function fetchChildrenById($id)
    {
        $children = Question::where('parent_id', '=', $id)->get();
        return $children;
    }
    public function updateCurrentQuestion($id)
    {
        $this->currentQuestion = $id;
    }

    public function fetchContactById($id)
    {
        return Contact::find($id);
    }
    public function render()
    {
        $question = $this->fetchCurrentQuestionById($this->currentQuestion);
        $children = $this->fetchChildrenById($this->currentQuestion);

//        if ($question->id === 2) {
//            dd($children);
//        }

        return view('livewire.contact-flow', compact('question', 'children'));
    }
}
