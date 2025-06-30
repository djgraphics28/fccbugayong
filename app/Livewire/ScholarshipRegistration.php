<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Mail;
use App\Mail\ScholarshipConfirmation;

class ScholarshipRegistration extends Component
{
    public $first_name, $middle_name, $last_name, $suffix;
    public $gender, $birth_date, $age, $contact_number, $email, $facebook;
    public $address;
    public $father_name, $father_occupation, $father_contact;
    public $mother_name, $mother_occupation, $mother_contact;
    public $guardian_name, $guardian_relation, $guardian_contact;

    public $showSuccess = false;

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:Male,Female',
        'birth_date' => 'required|date',
        'contact_number' => 'required|string|max:20',
        'email' => 'required|email|max:255',
        'address' => 'required|string|max:500',
        'father_name' => 'required|string|max:255',
        'father_occupation' => 'nullable|string|max:255',
        'father_contact' => 'nullable|string|max:20',
        'mother_name' => 'required|string|max:255',
        'mother_occupation' => 'nullable|string|max:255',
        'mother_contact' => 'nullable|string|max:20',
        'guardian_name' => 'nullable|string|max:255',
        'guardian_relation' => 'nullable|string|max:255',
        'guardian_contact' => 'nullable|string|max:20',
    ];

    public function submit()
    {
        $this->validate();

        try {
            // Map the fields to your database columns
            $data = [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'suffix' => $this->suffix,
                'gender' => $this->gender,
                'birth_date' => $this->birth_date,
                'age' => $this->age,
                'contact_number' => $this->contact_number,
                'email' => $this->email,
                'facebook_profile' => $this->facebook,
                'address' => $this->address,
                'father_name' => $this->father_name,
                'father_occupation' => $this->father_occupation,
                'father_contact_number' => $this->father_contact,
                'mother_name' => $this->mother_name,
                'mother_occupation' => $this->mother_occupation,
                'mother_contact_number' => $this->mother_contact,
                'guardian_name' => $this->guardian_name,
                'guardian_relationship' => $this->guardian_relation,
                'guardian_contact_number' => $this->guardian_contact,
            ];

            // Create scholarship record
            $scholarship = Scholarship::create($data);

            try {
                // Send confirmation email
                Mail::to($this->email)->send(new ScholarshipConfirmation($scholarship));
            } catch (\Exception $e) {
                // Log email error but continue execution
                \Log::error('Failed to send scholarship confirmation email: ' . $e->getMessage());
            }

            $this->showSuccess = true;

        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while processing your application.');
            \Log::error('Scholarship registration error: ' . $e->getMessage());
        }
    }

    public function applyAnother()
    {
        $this->resetExcept('showSuccess');
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.scholarship-registration');
    }
}
