<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserPivot;
use App\Metadata;
use App\Jawaban;
use App\Formulir;
use App\Pengajuan;
use Auth;
use Hash;

class DataController extends Controller
{
    public function dashboard(){
        if(Auth::user()->id_role==1){
            $dataSekolah = User::where('id_role', 2)->get();
            $sekolah = UserPivot::where('id_child', Auth::user()->id)->get();
            $detailSekolah = [];
            if(count($sekolah)>0){
                $sekolah = UserPivot::where('id_child', Auth::user()->id)->whereIn('id_user', $dataSekolah)->first();
                $detailSekolah = User::find($sekolah->id_user);
            }

            $dataPengajuan = Pengajuan::where('id_user', Auth::user()->id)->where('verifikasi', 0)->first();
            // dd($dataPengajuan);
            
            return view('dashboard', ['sekolah'=>$detailSekolah, 'dataSekolah'=>$dataSekolah, 'dataPengajuan'=>$dataPengajuan]);
        }
        return view('dashboard');
    }

    public function pengajuan(){
        
        $pengajuan = new Pengajuan();
        $pengajuan->id_user = Auth::user()->id;
        $pengajuan->id_user_sekolah = request('sekolah');
        $pengajuan->verifikasi = 0;

        $pengajuan->save();

        return redirect()->action('DataController@dashboard')->with('success', 'Pengajuan Berhasil');
    }

    public function verifikasi(){
        $pengajuan = Pengajuan::where('id_user_sekolah', Auth::user()->id)->where('verifikasi', 0)->get();
        $dataSiswa = [];
        foreach($pengajuan as $unit){
            array_push($dataSiswa, User::find($unit->id_user));
        }
        return view('verifikasi', ['siswa'=>$dataSiswa]);
    }

    public function verifikasiSiswa($id){
        $pengajuan = Pengajuan::where('id_user',$id)->first();
        $pengajuan->verifikasi=1;
        
        // Get semua id parents
        $listRelasi = [];
        $relasi = Auth::user()->parents()->get();
        foreach($relasi as $unit){
            array_push($listRelasi, $unit->id);
        }
        array_push($listRelasi, Auth::user()->id);

        // Simpan setiap id parent dan dipasangkan dengan id siswa
        foreach($listRelasi as $unit){
            $relasi = new UserPivot();
            $relasi->id_user=$unit;
            $relasi->id_child=$id;
            $relasi->save();
        }

        $pengajuan->save();

        return redirect()->action('DataController@verifikasi')->with('success', 'Data Berhasil Diverifikasi');
    }

    public function tolakSiswa($id)
    {
        try {
            $pengajuan = Pengajuan::where('id_user' ,$id);
            $pengajuan->delete();
        }catch (QueryException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('DataController@verifikasi')->with('success', 'Pengajuan Siswa Ditolak');
    }


    public function dataSiswa(){
        $id_user= Auth::user();
        $tahunAjar = Metadata::where('key', 'tahun-ajaran')->first();
        $cekForm = Formulir::select('id')->where('tahun_ajaran', $tahunAjar->data)->get();

        if($id_user->id==1){
            $dataSiswa = User::leftJoin('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')
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
                $dataSiswa = User::select('id','nama', 'id_role', 'username', 'kelas', 'tahun_ajaran')->where('id_role',1)->get();

                return view('data.dataSiswa', ['dataSiswa'=>$dataSiswa]);
            }
            

        }
        else{
            // $user = User::find($id_user->id);
            // $siswa = $user->users()->where('id_role',1)->get();

            $dataSiswa = User::findOrFail($id_user->id)->users()->where('id_role', 1)
            ->leftJoin('jawaban', 'users.id', '=', 'jawaban.id_user')
            ->select('users.id', 'users.nama', 'users.username', 'users.kelas', 'jawaban.validasi', 'jawaban.updated_at')
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
                $dataSiswa = $id_user->users()->select('users.id','users.nama', 'users.id_role', 'users.username', 'users.kelas', 'users.tahun_ajaran')->where('id_role',1)->get();
                return view('data.dataSiswa', ['dataSiswa'=>$dataSiswa]);
            }
        }
    
        return view('data.dataSiswa', ['dataSiswa' => $dataSiswa]);
    }
    public function detailSiswa($id){
        $detailSiswa = User::findOrFail($id);
        $sekolah = $detailSiswa->parents()->first();
        $allJawaban = Jawaban::where('id_user', $detailSiswa->id)->with('getFormulir','getFormulir.pertanyaan')->get();
        
        return view('data.detailSiswa', ['siswa' => $detailSiswa, 'allJawaban'=>$allJawaban, 'sekolah'=>$sekolah]);
    }
    public function pindahSiswa($id){
        try{
            UserPivot::where('id_child', $id)->delete();
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('DataController@dataSiswa')->with('success', 'Data Berhasil Dihapus');
    }

    public function resetPasswordSiswa($id){
        try{
            $siswa = User::find($id);
            $siswa->password = Hash::make($siswa->username);
            $siswa->save();
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        return back()->with('success', 'Password Berhasil di-reset');
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
        $id_user= Auth::user();
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
            $dataSiswa = User::findOrFail($id)->users()->select('users.id','users.nama', 'users.id_role', 'users.username', 'users.kelas', 'users.tahun_ajaran')->where('id_role',1)->get();
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
