<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role' => 'Siswa'],
            ['id' => 2, 'role' => 'Sekolah'],
            ['id' => 3, 'role' => 'Kelurahan'],
            ['id' => 4, 'role' => 'Puskesmas'],
            ['id' => 5, 'role' => 'Kecamatan'],
            ['id' => 6, 'role' => 'Kota']
        ]);
    }
}
