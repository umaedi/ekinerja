<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class UserExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return \App\Models\Pegawai::all();
    }
}
