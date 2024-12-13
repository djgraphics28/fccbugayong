<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "ext_name",
        "birth_date",
        "address",
        "contact_number",
        "invited_by"
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'invited_by', 'id');
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->ext_name;
    }

}
