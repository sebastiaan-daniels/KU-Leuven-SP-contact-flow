<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Validator;
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
        // Normalize the values to null if they are empty strings
        $this->contact_id = $this->contact_id === '' ? null : $this->contact_id;
        $this->child_question = $this->child_question === '' ? null : $this->child_question;
        $this->validate($this->rules());
        $this->validateChildQuestionOrContactId();
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

        $this->validate($this->rules($question->id), $this->messages());
        $this->validateChildQuestionOrContactId();
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
            'parent_id' => $id === 1 ? 'nullable|integer' : 'required|integer',
        ];
    }

    protected function messages()
    {
        return [
            'type.required' => 'The question type is required.',
            'contact_id.integer' => 'Ongeldig contact, Hoe zie je deze error zelfs?',
            'name.required' => 'Je moet een vraag invullen',
            'name.string' => 'The question name must be a string.',
            'child_question.string' => 'The child question must be a string.',
            'parent_id.integer' => 'Je moet een vorige vraag selecteren',
        ];
    }

    // Custom validation logic
    protected function validateChildQuestionOrContactId()
    {
        $validator = Validator::make([
            'contact_id' => $this->contact_id,
            'child_question' => $this->child_question,
        ], [
            'contact_id' => 'nullable',
            'child_question' => 'nullable',
        ]);

        if (is_null($this->contact_id) && is_null($this->child_question)) {
            $validator->errors()->add('contact_id', 'Er moet een contact OF volgende vraag ingegeven worden');
        }

        if (!is_null($this->contact_id) && !is_null($this->child_question)) {
            $validator->errors()->add('contact_id', 'Het is niet mogelijk een contact EN volgende vraag in te geven');
        }

        if ($validator->errors()->isNotEmpty()) {
            $this->setErrorBag($validator->errors());
            throw new \Illuminate\Validation\ValidationException($validator);
        }
    }

}
