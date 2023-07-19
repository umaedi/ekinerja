<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    public function model(array $row)
    {
        return new User([
            'bidang_id' => $row[0],
            'nip'       => $row[1],
            'nama'      => $row[2],
            'email'      => $row[3],
            'no_tlp'    => $row[4],
            'password'  => Hash::make($row[5]),
            'img'       => $row[6],
            'level'     => $row[7],
        ]);
    }
}
