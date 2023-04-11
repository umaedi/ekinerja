<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PegawaiImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {
            Pegawai::create([
                'bagian_id' => $row[0],
                'nip'       => $row[1],
                'name'      => $row[2],
                'golongan'  => $row[3],
                'email'     => $row[4],
                'no_tlp'    => $row[5],
                'password'  => $row[6],

            ]);
        }
    }
}
