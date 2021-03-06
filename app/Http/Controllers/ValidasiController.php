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
                                where('validasi_sekolah', 0)->get();
            
            return view('validasi', ['siswa' => $dataValid]);
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
                                'getSekolah'=>function($query) {$query->select('id','nama');},])->whereIn('id_user', $idSiswa)->get();
            
            if($id_user->id_role==4){
                $siswa = $dataValid->where('validasi_sekolah', 1)->where('validasi_puskesmas', 0)->whereIn('id_user', $idSiswa);    
            }
            elseif($id_user->id_role==2){
                $siswa = $dataValid->where('validasi_sekolah', 0)->whereIn('id_user', $idSiswa);
            }
            else{
                $siswa = $dataValid->where('validasi_puskesmas', 0)->whereIn('id_user', $idSiswa);
            }
            return view('validasi', ['siswa' => $siswa]);
        }
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

    public function validasi(Request $request, $id_jawaban){
        $user = Auth::user();
        $jawaban = Jawaban::findOrFail($id_jawaban);
        $listJawaban = json_decode($jawaban->json);
        $flag = 0;
        $diisiPetugas = $request->input('keterangan');
        foreach($listJawaban as $unit){
            if(empty($unit) and array_key_exists($key, $diisiPetugas)===false){
                $flag = 1;
                break;
            }
        }
        if($flag==0 && $user->id_role==2){
            $jawaban->validasi_sekolah = 1;
            $jawaban->save();
    
            return redirect('/validasi')->with('success', 'Data Skrining Berhasil Divalidasi');
        }
        elseif($user->id_role==4){
            $jawaban->keterangan = request('keterangan');
            $jawaban->validasi_puskesmas = request('kesimpulan');
            $jawaban->save();
    
            return redirect('/validasi')->with('success', 'Data Skrining Berhasil Divalidasi');
        }
        return back()->with('error', 'Data Skrining Masih Belum Lengkap');
    }

    public function rujukan(){
        $user = Auth::user();
        $rujukan = Jawaban::select('id', 'id_user', 'id_user_sekolah', 'validasi_puskesmas', 'keterangan', 'updated_at')->where('validasi_puskesmas', -1)->
                    with(['getUser'=>function($query){$query->select('id','nama', 'kelas');},
                    'getSekolah'=>function($query){$query->select('id', 'nama');}])->get();
        // dd($rujukan);
        return view('rujukan', ['rujukan'=>$rujukan]);
    }

    public function validasiRujukan($id){
        $rujukan = Jawaban::findOrFail($id);
        $rujukan->validasi_puskesmas = 2;
        $rujukan->keterangan = $rujukan->keterangan.'&#13;&#10;===================================&#13;&#10;'.request('keterangan2');
        
        $rujukan->save();

        return redirect('/rujukan')->with('success', 'Data Rujukan Berhasil Divalidasi');
    }
}
