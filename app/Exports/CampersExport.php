<?php

namespace App\Exports;

use App\Models\YouthCAmp;
use Maatwebsite\Excel\Concerns\FromCollection;

class CampersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return YouthCAmp::all();
    }
}
