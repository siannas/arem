<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Metadata;
use App\Jawaban;
use App\Formulir;
use Auth;

class DataController extends Controller
{
    public function dataSiswa(){
        $id_user= Auth::user();
        $tahunAjar = Metadata::where('key', 'tahun-ajaran')->first();
        $cekForm = Formulir::select('id')->where('tahun_ajaran', $tahunAjar->data)->get();

        if($id_user->id==1){
            $dataSiswa = User::leftJoin('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.created_at')
            ->where('id_role', 1)->whereIn('jawaban.id_formulir', $cekForm)->get();
            
            if (count($dataSiswa)!=0){
                foreach($dataSiswa as $unit){
                    $idSiswa[] = $unit->id;
                }
                $dataSiswaB = User::select('id', 'nama', 'username', 'kelas')->where('id_role',1)->whereNotIn('id', $idSiswa)->get();
                $dataCampur = $dataSiswa->concat($dataSiswaB);

                return view('data.dataSiswa', ['dataSiswa' => $dataCampur]);
            }
            else{
                $dataSiswa = User::where('id_role',1)->get();

                return view('data.dataSiswa', ['dataSiswa'=>$dataSiswa]);
            }
            

        }
        else{
            // $user = User::find($id_user->id);
            // $siswa = $user->users()->where('id_role',1)->get();

            $dataSiswa = User::findOrFail($id_user->id)->users()->where('id_role', 1)
            ->leftJoin('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.created_at')
            ->whereIn('jawaban.id_formulir', $cekForm)->get();
            
            if (count($dataSiswa)!=0){
                foreach($dataSiswa as $unit){
                    $idSiswa[] = $unit->id;
                }
                $dataSiswaB = User::find($id_user->id)->users()->select('users.id', 'users.nama', 'users.username', 'users.kelas')->where('id_role',1)->whereNotIn('users.id', $idSiswa)->get();
                $dataCampur = $dataSiswa->concat($dataSiswaB);

                return view('data.dataSiswa', ['dataSiswa' => $dataCampur]);
            }
            else{
                $dataSiswa = User::findOrFail($id_user->id)->users()->where('id_role',1)->get();
                return view('data.dataSiswa', ['dataSiswa'=>$dataSiswa]);
            }
        }
    
        return view('data.dataSiswa', ['dataSiswa' => $dataSiswa]);
    }
    public function detailSiswa($id){
        $detailSiswa = User::findOrFail($id);
        
        return view('data.detailSiswa', ['siswa' => $detailSiswa]);
    }

    public function dataSekolah(){
        $id_user= Auth::user();
        if($id_user->id==1){
            $dataSekolah = User::where('id_role',2)->get();        
        }
        else{
            $user = User::find($id_user->id);
            $dataSekolah = $user->users()->where('id_role',2)->get();        
        }
        
        return view('data.dataSekolah', ['dataSekolah' => $dataSekolah]);
    }
    public function detailSekolah($id){
        $tahunAjar = Metadata::where('key', 'tahun-ajaran')->first();
        $cekForm = Formulir::select('id')->where('tahun_ajaran', $tahunAjar->data)->get();
        
        $detailSekolah = User::findOrFail($id);
        $dataSiswa = User::findOrFail($id)->users()->where('id_role', 1)
        ->leftJoin('jawaban', 'users.id', '=', 'jawaban.id_user')
        ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.created_at')
        ->whereIn('jawaban.id_formulir', $cekForm)->get();
        
        if (count($dataSiswa)!=0){
            foreach($dataSiswa as $unit){
                $idSiswa[] = $unit->id;
            }
            $dataSiswaB = User::findOrFail($id)->users()->select('users.id', 'users.nama', 'users.username', 'users.kelas')->where('users.id_role',1)->whereNotIn('users.id', $idSiswa)->get();
            $dataCampur = $dataSiswa->concat($dataSiswaB);

            return view('data.detailSekolah', ['sekolah' => $detailSekolah, 'siswa' => $dataCampur]);
        }
        else{
            $dataSiswa = User::where('id_role',1)->get();

            return view('data.detailSekolah', ['sekolah' => $detailSekolah, 'siswa'=>$dataSiswa]);
        }
        
    }

    public function dataKelurahan(){
        $id_user= Auth::user();
        if($id_user->id==1){
            $dataKelurahan = User::where('id_role',3)->get();    
        }
        else{
            $user = User::find($id_user->id);
            $dataKelurahan = $user->users()->where('id_role',3)->get();    
        }
        
        return view('data.dataKelurahan', ['dataKelurahan' => $dataKelurahan]);
    }
    public function detailKelurahan($id){
        $detailKelurahan = User::findOrFail($id);
        $sekolah = $detailKelurahan->users()->where('id_role', 2)->get();

        return view('data.detailKelurahan', ['kelurahan' => $detailKelurahan, 'sekolah' => $sekolah]);
    }

    public function dataPuskesmas(){
        $id_user= Auth::user();
        if($id_user->id==1){
            $dataPuskesmas = User::where('id_role',4)->get();
        }
        else{
            $user = User::find($id_user->id);
            $dataPuskesmas = $user->users()->where('id_role',4)->get();    
        }
        
        return view('data.dataPuskesmas', ['dataPuskesmas' => $dataPuskesmas]);
    }
    public function detailPuskesmas($id){
        $detailPuskesmas = User::findOrFail($id);
        $kelurahan = $detailPuskesmas->users()->where('id_role', 3)->get();

        return view('data.detailPuskesmas', ['puskesmas' => $detailPuskesmas, 'kelurahan' => $kelurahan]);
    }

    public function dataKecamatan(){
        $dataKecamatan = User::where('id_role', 5)->get();

        return view('data.dataKecamatan', ['dataKecamatan' => $dataKecamatan]);
    }
    public function detailKecamatan($id){
        $detailKecamatan = User::findOrFail($id);
        $puskesmas = $detailKecamatan->users()->where('id_role', 4)->get();

        return view('data.detailKecamatan', ['kecamatan' => $detailKecamatan, 'puskesmas' => $puskesmas]);
    }
}
