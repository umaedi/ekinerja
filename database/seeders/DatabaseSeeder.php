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

        $users = [
            [
                'nip'       => '17081998',
                'nama'      => 'Dev KH',
                'email'     => 'devkh@gmail.com',
                'no_tlp'    => '085741492045',
                'password'  => bcrypt('devkh123'),
                'level'     => 'kadis',
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }

        $jabatans = [
            [
                'nama_jabatan' => 'Sekretaris Dinas',
            ],
            [
                'nama_jabatan' => 'Kepala Bidang',
            ],
            [
                'nama_jabatan' => 'Staf',
            ],
        ];

        foreach ($jabatans as $jabatan) {
            \App\Models\Jabatan::create($jabatan);
        }
    }
}
