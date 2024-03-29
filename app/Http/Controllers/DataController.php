<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserPivot;
use App\Jawaban;
use App\Formulir;
use App\Pengajuan;
use App\Metadata;
use Datatables;
use Auth;
use Hash;
use Validator;
use Artisan;
use Illuminate\Http\Exceptions\HttpResponseException;

class DataController extends Controller
{
    public function dashboard(){
        $user = Auth::user();
        $listSekolah=[];
        if($user->id_role==1){
            // Cari relasi yang berhubungan dengan user login
            $sekolah = UserPivot::where('id_child', $user->id)->get();
            if(count($sekolah)>0){
                // Get data sekolah
                $dataSekolah = User::where('id_role', 2)->select('id')->get();
                $sekolah = UserPivot::where('id_child', Auth::user()->id)->whereIn('id_user', $dataSekolah)->first();
                $detailSekolah = User::find($sekolah->id_user);
            }
            else{
                // Get data semua sekolah untuk daftar
                $dataSekolah = User::where('id_role', 2)->get();
                $detailSekolah = [];
            }
            // Cari data pengajuan yg blm diverifikasi
            $dataPengajuan = Pengajuan::where('id_user', Auth::user()->id)->where('verifikasi', 0)->first();
            
            return view('dashboard', ['sekolah'=>$detailSekolah, 'dataSekolah'=>$dataSekolah, 'dataPengajuan'=>$dataPengajuan]);
        }
        else{
            $statusList = [0,0,0,0,0,0,0,0];
            $listSekolah = array();
            $counter = 0;

            // Penghitungan Status Role Dinas
            if($user->id_role == 6){
                if($user->id==1) $relasi = User::where('id_role', 2)->get();
                else $relasi = User::where('id_role', 2)->where('jenis', $user->jenis)->get();
                foreach($relasi as $unit){
                    $status = Metadata::where('key', 'jumlah_status_'.$unit->id)->first();
                    if(isset($status)){
                        $listSekolah[$counter][0] = $unit->nama;
                        $tempStatus = explode(',', $status->value);
                        for($i=1;$i<count($tempStatus);$i++){
                            $statusList[$i] += intval($tempStatus[$i]);
                            $listSekolah[$counter][$i] = $tempStatus[$i];
                        }
                        $counter++;
                    }   
                }
            }
            // Penghitungan Status Role Selain Dinas & Sekolah
            elseif($user->id_role != 2){
                $relasi = $user->users()->where('id_role', 2)->get();
                foreach($relasi as $unit){
                    $status = Metadata::where('key', 'jumlah_status_'.$unit->id)->first();
                    $tempStatus = explode(',', $status->value);
                    for($i=1;$i<count($tempStatus);$i++){
                        $statusList[$i] += intval($tempStatus[$i]);
                    }   
                }
            }
            // Penghitungan Status Role Sekolah
            else{
                $relasi = [];
                $status = Metadata::where('key', 'jumlah_status_'.$user->id)->first();
                if(isset($status)) $statusList = explode(',', $status->value);
            }

            $jumlahSiswa = Metadata::where('key', 'jumlah_siswa')->first();
            $jumlahSiswa = explode(',', $jumlahSiswa->value);
            $pengumuman = Metadata::where('key', 'pengumuman')->first();
            $update = Metadata::where('key','last_update')->first();
        }
        return view('dashboard', ['statusList' => $statusList, 'jumlahSiswa' => $jumlahSiswa, 'pengumuman' => $pengumuman, 'sekolah'=>$relasi, 'update'=>$update, 'listSekolah'=>$listSekolah]);
    }

    public function refresh(){
        Artisan::call('updateDashboard');
        return redirect()->back()->with('success','Data Berhasil Diperbarui');
    }

    public function simpanPengumuman(Request $request){
        $pengumuman = Metadata::where('key', 'pengumuman')->first();
        $pengumuman->value = $request->deskripsi;
        // dd($pengumuman);
        $pengumuman->save();

        return redirect()->action('DataController@dashboard')->with('success', 'Pengumuman Berhasil Diubah');
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
        $pengajuan = Pengajuan::where('id_user',$id)->where('verifikasi', 0)->first();
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

    public function tolakSiswa($id){
        try {
            $pengajuan = Pengajuan::where('id_user' ,$id)->where('verifikasi', 0);
            $pengajuan->delete();
        }catch (QueryException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('DataController@verifikasi')->with('success', 'Pengajuan Siswa Ditolak');
    }

    public function dataSiswa(){
        return view('data.dataSiswa');
    }

    public function siswaData(Request $request){
        // Lebih cepet pake raw() src: https://geekflare.com/laravel-optimization/
        // $data = User::raw('select * from user');
        $id_user= Auth::user();
        if($id_user->id_role==6){
            if(!isset($id_user->jenis)){
                $dataSiswa = User::with(['getSekolah:nama,jenis'])
                    ->select('id', 'nama', 'id_role', 'username', 'kelas', 'tahun_ajaran')
                    ->where('id_role',1);
            } else{
                $sekolah = User::where('id_role',2)->where('jenis',$id_user->jenis)->get();
                $listSiswa = [];
                
                // Simpan id setiap sekolah
                foreach($sekolah as $unit){
                    $siswa = $unit->users()->where('id_role',1)->get();
                    foreach($siswa as $unit2){
                        array_push($listSiswa, $unit2->id);
                    }
                }
                
                $dataSiswa = User::with(['getSekolah:nama,jenis'])
                    ->select('id', 'nama', 'id_role', 'username', 'kelas', 'tahun_ajaran')
                    ->where('id_role',1)->whereIn('id', $listSiswa);
            }
            
        }
        else{
            // List siswa di bawah naungan user login
            $siswa = Auth::user()->users()->select('users.id')->where('id_role', 1)->get();
            $listSiswa = [];

            // Simpan id setiap siswa
            foreach($siswa as $unit){
                array_push($listSiswa, $unit->id);
            }

            $dataSiswa = User::with(['getSekolah:nama'])
            ->select('id', 'nama', 'id_role', 'username', 'kelas', 'tahun_ajaran')
            ->where('id_role',1)->whereIn('id', $listSiswa);
        }
        
        $datatable = Datatables::of($dataSiswa);
        $datatable->rawColumns(['action']);
        if($id_user->id_role == 2){
            $datatable->addColumn('action', function ($t) {
                return '<a href="'.url('data-siswa').'/'.$t->id.'" class="btn btn-info btn-link" style="padding:5px;" data-toggle="tooltip" data-placement="top" title="Lihat Detail Siswa"><i class="fas fa-fw fa-eye" style="color:white;"></i></a>&nbsp'.
                '<button type="button" class="btn btn-warning btn-link" style="padding:5px;" onclick="edit(this)"><i class="fas fa-fw fa-edit" style="color:white;"></i></button>&nbsp';
            });
        }else{
            $datatable->addColumn('action', function ($t) {
            return '<a href="'.url('data-siswa').'/'.$t->id.'" class="btn btn-info btn-link" style="padding:5px;" data-toggle="tooltip" data-placement="top" title="Lihat Detail Siswa"><i class="fas fa-fw fa-eye" style="color:white;"></i></a>&nbsp';
            });
        }
        return $datatable->make(true); 
    }

    public function detailSiswa($id){
        $detailSiswa = User::findOrFail($id);
        // $sekolah = $detailSiswa->parents()->where('id_role', 2)->first();
        $allJawaban = Jawaban::where('id_user', $detailSiswa->id)->with('getFormulir','getSekolah:id,nama')->get();
        // dd($allJawaban);
        return view('data.detailSiswa', ['siswa' => $detailSiswa, 'allJawaban'=>$allJawaban]);
    }

    public function editSiswa(Request $request){
        $detailSiswa = User::findOrFail($request->id);
        $detailSiswa->username = request('editUsername');
        $detailSiswa->nama = request('editNama');
        $detailSiswa->kelas = request('editKelas');
        $detailSiswa->save();
        
        return redirect()->action('DataController@dataSiswa')->with('success', 'Data Siswa Berhasil Diubah');
    }

    public function naikKelas($id){
        
        $detailSiswa = User::findOrFail($id);
        $detailSiswa->kelas = $detailSiswa->kelas+1;
        
        $detailSiswa->save();

        return redirect()->action('DataController@dataSiswa')->with('success', 'Data Siswa Berhasil Diubah');
    }

    public function pindahSiswa($id){

        try{
            UserPivot::where('id_child', $id)->delete();
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('DataController@dataSiswa')->with('success', 'Siswa Berhasil Dikeluarkan Dari Sekolah');
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
        if($id_user->id_role==6){
            if($id_user->id==1) $dataSekolah = User::where('id_role',2)->get();
            else $dataSekolah = User::where('id_role',2)->where('jenis',$id_user->jenis)->get();
        }
        else{
            $dataSekolah = $id_user->users()->where('id_role',2)->get();        
        }
        
        return view('data.dataSekolah', ['dataSekolah' => $dataSekolah]);
    }
    public function detailSekolah($id){
        $id_user= Auth::user()->users()->get();
        
        $detailSekolah = User::findOrFail($id);
        $dataSiswa = User::findOrFail($id)->users()->select('users.id', 'nama', 'username', 'kelas')->where('id_role', 1)->get();
        
        return view('data.detailSekolah', ['sekolah' => $detailSekolah, 'siswa'=>$dataSiswa]);
    }

    public function dataKelurahan(){
        $id_user= Auth::user();
        if($id_user->id_role==6){
            $dataKelurahan = User::where('id_role',3)->get();    
        }
        else{
            $dataKelurahan = $id_user->users()->where('id_role',3)->get();    
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
        if($id_user->id_role==6){
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

    public function dataSiswaDanFormSkrining(){
        $user= Auth::user();
        $formulir=Formulir::where('status', 1)->get();
        if($user->id_role==6){
            $sd=User::where([['id_role',2],['kelas',1]])->get();
            $smpsma=User::where([['id_role',2],['kelas',7]])->get();
        }
        else{
            $sd=$user->users()->where([['id_role',2],['kelas',1]])->get();
            $smpsma=$user->users()->where([['id_role',2],['kelas',7]])->get();
        }
        
        return view('isiData', ['formulir'=>$formulir, 'sd'=>$sd, 'smpsma'=>$smpsma]);
    }

    public function dataSiswaFiltered(Request $request){
        $validator = Validator::make($request->all(), [
            'formulir' => 'required',
            'sekolah' => 'required',
            'pertanyaan' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $sekolah = explode('_',$request->input('sekolah'))[0];
        $idForm = $request->input('formulir');

        if($request->input('kelas') !== null and $request->input('kelas') !== 'all'){
            $siswa= User::findOrFail($sekolah)->users()->where([['id_role',1],['kelas',$request->input('kelas')]])
                ->with(['jawabans'=> function($query) use ($idForm) {$query->where('id_formulir',$idForm);}])
                ->get();
        }else{
            $siswa= User::findOrFail($sekolah)->users()->where('id_role',1)
                ->with(['jawabans'=> function($query) use ($idForm) {$query->where('id_formulir',$idForm);}])
                ->get();
        }
        
        return $siswa;
    }
}
