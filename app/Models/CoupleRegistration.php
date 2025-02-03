<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoupleRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'husband_name',
        'wife_name',
        'address',
        'contact_number',
    ];
}
