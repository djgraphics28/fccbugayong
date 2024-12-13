<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Family extends Model
{
    use HasFactory;

    protected $table = 'families';

    protected $fillable = [
        'family_name',
        'father',
        'mother',
    ];

    public function member()
    {
        return $this->belongsToMany(Member::class);
    }

    public function fatherData()
    {
        return $this->belongsTo(Member::class, 'father', 'id')->where('gender', 'Male');
    }

    public function motherData()
    {
        return $this->belongsTo(Member::class, 'mother', 'id')->where('gender', 'Female');
    }
}
