<?php

namespace App\Livewire;

use Livewire\Component;

class ScholarshipRegistration extends Component
{
    public $first_name, $middle_name, $last_name, $suffix;
    public $gender, $birth_date, $age, $contact_number, $email, $facebook;
    public $address;
    public $father_name, $father_occupation, $father_contact;
    public $mother_name, $mother_occupation, $mother_contact;
    public $guardian_name, $guardian_relation, $guardian_contact;

    protected $rules = [
        'first_name' => 'required|string',
        'last_name' => 'required|string',
        'gender' => 'required|in:Male,Female',
        'birth_date' => 'required|date',
        'contact_number' => 'required',
        'email' => 'nullable|email',
        'address' => 'required|string',

        'father_name' => 'required|string',
        'father_occupation' => 'nullable|string',
        'father_contact' => 'nullable|string',

        'mother_name' => 'required|string',
        'mother_occupation' => 'nullable|string',
        'mother_contact' => 'nullable|string',

        'guardian_name' => 'nullable|string',
        'guardian_relation' => 'nullable|string',
        'guardian_contact' => 'nullable|string',
    ];

    public function submit()
    {
        $this->validate();

        App\Models\ScholarshipRegistration::create($this->only([
            'first_name', 'middle_name', 'last_name', 'suffix', 'gender',
            'birth_date', 'age', 'contact_number', 'email', 'facebook', 'address',
            'father_name', 'father_occupation', 'father_contact',
            'mother_name', 'mother_occupation', 'mother_contact',
            'guardian_name', 'guardian_relation', 'guardian_contact',
        ]));

        session()->flash('success', 'Registration submitted successfully!');
        $this->reset();
    }

    public function render()
    {
        return view('livewire.scholarship-registration');
    }
}
