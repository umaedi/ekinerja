<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bidangs = [
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Madya 1.1'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Madya 1.2'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Madya 2.1'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Madya 2.2'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 1.1'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 1.2'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 1.3'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 1.4'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 2.1'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 2.2'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 2.3'],
            ['nama_bidang'  => 'Analisis Kebiajakan Ahli Muda 2.4'],
        ];

        foreach ($bidangs as $bidang) {
            \App\Models\Bidang::create($bidang);
        }
    }
}
