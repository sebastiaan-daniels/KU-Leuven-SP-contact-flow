<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Question;
use Illuminate\Validation\Rule;

class QuestionForm extends Form
{
    public $id = null;

    public $type = null;
    public $contact = null;
    public $name = null;
    public $child_question = null;
    public $parent = null;
    public $active = null;

    // create a new record
    public function create()
    {
        $this->validate($this->rules());
        Question::create([
            'type_id' => $this->type,
            'contact_id' => $this->contact,
            'name' => $this->name,
            'question' => $this->child_question,
            'parent_id' => $this->parent,
            'active' => true
        ]);
    }

    // update record
    public function update(Question $question) {
        $this->validate($this->rules($question->id));
        $question->update([
            'type_id' => $this->type,
            'contact_id' => $this->contact,
            'name' => $this->name,
            'question' => $this->child_question,
            'parent_id' => $this->parent,
            'active' => true
        ]);
    }

    // delete the selected record
    public function delete(Question $question)
    {
        $question->delete();
    }

    // Validation rules
    protected function rules($id = null)
    {
        return [
            'type_id' => 'required',
            'contact_id' => 'nullable|integer',
            'name' => 'required|string',
            'question' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ];
    }
}
