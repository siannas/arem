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
            $dataValid = Jawaban::with(['getUser'=>function($query) {$query->select('id','nama', 'kelas');},
                                'getSekolah'=>function($query) {$query->select('id','nama');},])->
                                where('validasi', 0)->get();
        }
        else{
            // Get data siswa dibawahnya
            $dataSiswa = $id_user->users()->get();
            $idSiswa = [];
            foreach($dataSiswa as $unit){
                array_push($idSiswa, $unit->id);
            }

            // Mencari data user yang sudah memberi jawaban
            $dataValid = Jawaban::with(['getUser'=> function($query) { $query->select('id','nama', 'kelas');},
                                'getSekolah'=>function($query) {$query->select('id','nama');},])->
                                where('validasi', 0)->whereIn('id_user', $idSiswa)->get();
            
            $siswa = $dataValid->where('validasi', 0)->whereIn('id_user', $idSiswa);
        }
        return view('validasi', ['siswa' => $dataValid]);
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
