<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Jawaban;
use App\Formulir;
use Auth;

class ValidasiController extends Controller
{
    public function validasi(){
        $id_user= Auth::user();
        if($id_user->id==1){
            $dataValid = User::join('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('jawaban.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')->get();
            // $dataValid = Jawaban::where('validasi', 0)->get();
            $siswa = $dataValid->where('validasi', 0);
            // $siswa = User::findOrFail($dataValid);
            
        }
        else{
            // $dataSiswa = User::findOrFail($id_user->id)->users()->where('id_role',1)->get();
            $dataValid = Jawaban::select('id_user')->where('validasi', 0)->get();
            $siswa = User::findOrFail($id_user->id)->users()->where('id_role',1)->whereIn('users.id', $dataValid)->get();
        }
    
        return view('validasi', ['siswa' => $siswa]);
    }

    public function validasiSiswa($id){
        $jawaban = Jawaban::findOrFail($id);
        $siswa = User::where('id', $jawaban->id_user)->first();
        $formulir = Formulir::where('id', $jawaban->id_formulir)->first();
        $pertanyaan = $formulir->pertanyaan;
        
        return view('validasiSiswa', ['siswa' => $siswa, 'formulir' => $formulir, 'allPertanyaan' => $pertanyaan]);
    }
}
