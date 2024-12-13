<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Member extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $table = 'members';

    protected $dates = ['birth_date'];

    protected $append = [
        'age'
    ];

    protected $fillable = [
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'ext_name',
        'nickname',
        'gender',
        'birth_date',
        'contact_number',
        'address',
        'email',
        'date_baptized',
        'is_first_time',
        'is_active',
        'is_approved',
        'e_signature',
        'position',
    ];

    // Define a mutator for the 'birth_date' attribute to ensure it is stored in the correct format
    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
    }

    // Define an accessor for the 'birth_date' attribute to ensure it is returned in the desired format
    public function getBirthDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }
    public function getAgeAttribute()
    {
        return $this->birth_date ? date_diff(date_create($this->birth_date), date_create('today'))->y . ' year(s) old' : '';
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Manipulations::FIT_CROP, 300, 300)
    //         ->nonQueued();
    // }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_picture')
            ->singleFile(); // Allow only one file in the collection
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->ext_name;
    }
}
