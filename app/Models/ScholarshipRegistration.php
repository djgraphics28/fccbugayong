<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScholarshipRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 'middle_name', 'last_name', 'suffix',
        'gender', 'birth_date', 'age', 'contact_number',
        'email', 'facebook', 'address',

        'father_name', 'father_occupation', 'father_contact',
        'mother_name', 'mother_occupation', 'mother_contact',

        'guardian_name', 'guardian_relation', 'guardian_contact',
        'status'
    ];
}
