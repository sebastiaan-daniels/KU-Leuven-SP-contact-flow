<?php

namespace App\Livewire;

use App\Models\Type;
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
        $children = Question::where('parent_id', '=', $id)
            ->where('active', true)
            ->get();
        return $children;
    }
    public function updateCurrentQuestion($id)
    {
        $this->currentQuestion = $id;
    }

    public function goBack($id)
    {
        // Fetches the ID of the parent question and sets it as the current question.
        $question = $this->fetchCurrentQuestionById($id);
        $this->currentQuestion = $question->parent_id;
        if ($id === 1) {
            $this->currentQuestion = 1;
        }
    }

    public function fetchContactById($id)
    {
        return Contact::find($id);
    }

    public function fetchTypeFromQuestionID($questionId)
    {
        return Type::find($this->fetchCurrentQuestionById($questionId)->type_id);
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
