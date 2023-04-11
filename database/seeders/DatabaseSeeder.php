<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\User::create([
            'nip'       => '197601XXXXXX',
            'name'      => 'Umaedi KH',
            'email'     => 'devkh@gmail.com',
            'no_tlp'    => '085741492045',
            'password'  => bcrypt('devkh123'),
        ]);

        // \App\Models\Pegawai::create([
        //     'bagian_id' => 0,
        //     'jabatan_id' => 1,
        //     'nip'       => '196711XXXXX',
        //     'name'      => 'DENI MUTTAQIN, S.Pd.,M.T',
        //     'email'     => 'sekretaris@gmail.com',
        //     'no_tlp'    => '0857XXXXXX',
        //     'password'  => 'sekretaris',
        //     'role'      => 3,
        // ]);

        // \App\Models\Pegawai::create([
        //     'bagian_id' => 1,
        //     'jabatan_id' => 1,
        //     'nip'       => '197812XXXXX',
        //     'name'      => 'ARYANTINA, S.E.',
        //     'email'     => 'ahlimuda@gmail.com',
        //     'no_tlp'    => '0857XXXXXX',
        //     'password'  => 'ahlimuda',
        //     'role'      => 3,
        // ]);

        // \App\Models\Pegawai::create([
        //     'bagian_id' => 2,
        //     'jabatan_id' => 1,
        //     'nip'       => '197504XXXXX',
        //     'name'      => 'DHARMA ARIA NUGRAHA, S.E.',
        //     'email'     => 'bagian@gmail.com',
        //     'no_tlp'    => '0857XXXXXX',
        //     'password'  => 'bagian',
        //     'role'      => 3,
        // ]);

        $bagian = [
            ['nama_bagian'  => 'Perencana Ahli Muda'],
            ['nama_bagian'  => 'Bagian Umum dan Kepegawaian'],
        ];

        foreach ($bagian as $value) {
            \App\Models\Bagian::create($value);
        }

        // $jabatan = [
        //     ['nama_jabatan' => 'Kepala Dinas'],
        //     ['nama_jabatan' => 'Sekretaris'],
        //     ['nama_jabatan' => 'Perencana Ahli Muda'],
        //     ['nama_jabatan' => 'Sub Bagian Umum dan Kepegawaian'],
        //     ['nama_jabatan' => 'Analisis Kebijakan Ahli Madya'],
        //     ['nama_jabatan' => 'Analisis Kebijakan Ahli Muda'],
        // ];

        // foreach ($jabatan as $value) {
        //     \App\Models\Jabatan::create($value);
        // }
    }
}
