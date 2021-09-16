<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ValidasiController extends Controller
{
    public function validasi(){
        $siswa = User::where('id_role', 1)->get();
        return view('validasi', ['siswa' => $siswa]);
    }

    public function validasiSiswa($id){
        $siswa = User::findOrFail($id);
        return view('validasiSiswa', ['siswa' => $siswa]);
    }
}
