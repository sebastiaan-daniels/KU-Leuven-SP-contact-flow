<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Question;
use Illuminate\Validation\Rule;

class QuestionForm extends Form
{
    public $id = null;

    public $type = 1;
    public $contact_id = null;
    public $name = null;
    public $child_question = null;
    public $parent_id = null;
    public $active = null;

    // create a new record
    public function create()
    {
        $this->validate($this->rules());
        Question::create([
            'type_id' => $this->type,
            'contact_id' => $this->contact_id,
            'name' => $this->name,
            'child_question' => $this->child_question,
            'parent_id' => $this->parent_id,
            'active' => true
        ]);
    }

    // update record
    public function update(Question $question) {
        // Normalize the values to null if they are empty strings
        $this->contact_id = $this->contact_id === '' ? null : $this->contact_id;
        $this->child_question = $this->child_question === '' ? null : $this->child_question;

        $this->validate($this->rules($question->id));
        $question->update([
            'type_id' => $this->type,
            'contact_id' => $this->contact_id,
            'name' => $this->name,
            'child_question' => $this->child_question,
            'parent_id' => $this->parent_id,
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
            'type' => 'required',
            'contact_id' => 'nullable|integer',
            'name' => 'required|string',
            'child_question' => 'nullable|string',
            'parent_id' => 'nullable|integer',
        ];
    }
}
