<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CoupleRegistration;

class CoupleRegistrationForm extends Component
{
    public $husband_name, $wife_name, $address, $contact_number;
    public $submitted = false;

    protected $rules = [
        'husband_name' => 'required|string|max:255',
        'wife_name' => 'required|string|max:255',
        'address' => 'required|string|max:500',
        'contact_number' => 'required|string|max:20',
    ];

    public function submit()
    {
        $this->validate();

        // Save to database
        CoupleRegistration::create([
            'husband_name' => $this->husband_name,
            'wife_name' => $this->wife_name,
            'address' => $this->address,
            'contact_number' => $this->contact_number,
        ]);

        $this->submitted = true; // Show the confirmation message
    }
    public function render()
    {
        return view('livewire.couple-registration-form');
    }
}
