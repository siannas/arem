<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Jawaban;
use App\Formulir;
use Auth;

class ValidasiController extends Controller
{
    public function index(){
        $id_user= Auth::user();
        if($id_user->id==1){
            // Mencari data user yang sudah memberi jawaban
            $dataValid = User::join('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('jawaban.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')->get();
            
            $siswa = $dataValid->where('validasi', 0);
        }
        else{
            // Mencari data user yang sudah memberi jawaban
            $dataValid = User::join('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('jawaban.id', 'jawaban.id_user', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')->get();
            
            // Get data siswa dibawahnya
            $dataSiswa = $id_user->users()->get();
            $idSiswa = [];
            foreach($dataSiswa as $unit){
                array_push($idSiswa, $unit->id);
            }
            $siswa = $dataValid->where('validasi', 0)->whereIn('id_user', $idSiswa);
        }
        return view('validasi', ['siswa' => $siswa]);
    }

    public function validasiSiswa($id_jawaban){
        $jawaban = Jawaban::findOrFail($id_jawaban);
        try{
            $siswa = User::where('id', $jawaban->id_user)->first();
            $formulir = Formulir::where('id', $jawaban->id_formulir)->first();
            $pertanyaan = $formulir->pertanyaan;
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        
        return view('validasiSiswa', ['siswa' => $siswa, 'formulir' => $formulir, 'allPertanyaan' => $pertanyaan, 'jawaban'=>$jawaban ]);
    }

    public function validasi($id_jawaban){
        $jawaban = Jawaban::findOrFail($id_jawaban);
        $jawaban->validasi = 1;
        $jawaban->save();

        return redirect('/validasi')->with('success', 'Data Berhasil Divalidasi');
    }
}
