<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Validation\Rule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    // public function model(array $row)
    // {
    //     return new User([
    //        'username'     => $row['nik'],
    //        'nama'    => $row['nama'], 
    //        'password' => Hash::make($row['nik']),
    //     ]);
    // }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $username = trim($row['nik']);
            $nama = trim($row['nama']);
            User::create([
                'username'=> empty($username)? null : $username,
                'nama'    => empty($nama) ? null : $nama, 
                'password' => Hash::make(empty($username)? 'password' : $username),
            ]);
        }
    }
}