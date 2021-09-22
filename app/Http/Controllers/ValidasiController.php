<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Jawaban;
use Auth;

class ValidasiController extends Controller
{
    public function validasi(){
        $id_user= Auth::user();
        if($id_user->id==1){
            $dataValid = User::join('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')->get();
            // $dataValid = Jawaban::where('validasi', 0)->get();
            $siswa = $dataValid->where('validasi', 0);
            // $siswa = User::findOrFail($dataValid);
            
        }
        else{
            $user = User::find($id_user->id);
            $dataSiswa = $user->users()->where('id_role',1)->get();
            $dataValid = Jawaban::select('id_user')->where('validasi', 0)->get();
            $siswa = $dataSiswa->where('id', $dataValid->id_user);
        }
    
        return view('validasi', ['siswa' => $siswa]);
    }

    public function validasiSiswa($id){
        $siswa = User::findOrFail($id);
        return view('validasiSiswa', ['siswa' => $siswa]);
    }
}
