<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\YouthCamp;

class LcrRegistrationForm extends Component
{
    public $first_name, $middle_name, $last_name, $suffix, $nickname, $birthday, $contact_number, $gender, $church, $is_visitor;
    public $submitted = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'middle_name' => 'nullable|string|max:255',
        'last_name' => 'required|string|max:255',
        'suffix' => 'nullable|string|max:10',
        'gender' => 'string',
        'nickname' => 'nullable|string|max:255',
        'birthday' => 'required|date',
        'contact_number' => 'required',
        'is_visitor' => 'required',
    ];

    public function submit()
    {
        $this->validate();

        // Save to database
        YouthCamp::create([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'gender' => $this->gender,
            'suffix' => $this->suffix,
            'nickname' => $this->nickname,
            'birthday' => $this->birthday,
            'contact_number' => $this->contact_number,
            'event' => 'lcr',
            'church' => $this->church,
        ]);

        $this->submitted = true; // Show the confirmation message

        // Reset form fields
        $this->reset(['first_name', 'middle_name', 'last_name', 'gender', 'suffix', 'nickname', 'birthday', 'contact_number', 'church','is_visitor']);

    }
    public function render()
    {
        return view('livewire.lcr-registration-form');
    }
}
