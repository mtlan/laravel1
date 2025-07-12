<?php

namespace App\Livewire;

use Livewire\Component;

class NgonNguTest extends Component
{
    public $ten, $ma;

    public function rules()
    {
        return [
            'ten' => 'required|string|max:255',
            'ma' => 'required|string|max:50',
        ];
    }

    public function isRequired($field)
    {
        $rules = $this->rules();
        $fieldRules = $rules[$field] ?? '';

        $ruleString = is_array($fieldRules) ? implode('|', $fieldRules) : $fieldRules;

        return str_contains($ruleString, 'required');
    }


    public function render()
    {
        return view('livewire.ngon-ngu-test');
    }
}
