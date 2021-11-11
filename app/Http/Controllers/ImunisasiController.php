<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Imunisasi;
use App\User;
use Illuminate\Support\Facades\Storage;

class ImunisasiController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->id_role==1){
            $imunisasi = Imunisasi::where('id_user', Auth::user()->id)->get();
        }
        elseif($user->id_role==6){
            $imunisasi = Imunisasi::with(['getUser'=> function($query) { $query->select('id','nama');},
                                    'getSekolah'=>function($query) {$query->select('nama');},])->get();
        }
        else{
            $dataSiswa = $user->users()->where('id_role', 1)->get();
            $idSiswa = [];
            foreach($dataSiswa as $unit){
                array_push($idSiswa, $unit->id);
            }
            $imunisasi = Imunisasi::with(['getUser'=> function($query) { $query->select('id','nama');},
                                    'getSekolah'=>function($query) {$query->select('nama');},])->whereIn('id_user', $idSiswa)->get();

            return view('profil.imunisasi', ['imunisasi' => $imunisasi, 'dataSiswa'=>$dataSiswa]);
        }

        return view('profil.imunisasi', ['imunisasi' => $imunisasi]);
    }

    public function store(Request $request){
        $user = Auth::user();
        if($user->id_role==1){
            $validator = Validator::make($request->all(), [
                'bukti'  =>  'required|file|mimetypes:image/jpg,image/jpeg,image/png,application/pdf|max:512',
            ]);
    
            if ($validator->fails()) {
                return back()->withError($validator->errors()->first('bukti'));
            }    

            // Simpan data imunisasi baru
            $imunisasi_baru = new Imunisasi($request->all());

            $imunisasi_baru->id_user = $user->id;

            $mime = $request->file('bukti')->getMimeType();
            $pattern = '/[a-zA-Z]+$/' ;
            preg_match($pattern, $mime, $matches);
            $mime = $matches[0];

            $filename = $user->id.':'.$imunisasi_baru->tanggal.'.'.$mime;
            $path = Storage::putFileAs(
                'imunisasi/',
                $request->file('bukti'),
                $filename
            );
            
            $url = url('/storage/app/imunisasi/'.$filename);

            $imunisasi_baru->fill(['bukti'=>$url]);
            $imunisasi_baru->validasi = 0;
        }
        elseif($user->id_role==4){
            $imunisasi_baru = new Imunisasi($request->all());
            $imunisasi_baru->validasi = 1;
        }
        
        $imunisasi_baru->save();

        $request->session()->forget('no-imunisasi');

        $imunisasi_baru->save();

        return redirect()->action('ImunisasiController@index')->with('success', 'Data Imunisasi Berhasil Ditambahkan, Silahkan Tunggu Verifikasi Dari Puskesmas');
    }

    public function validasi(){
        $user = Auth::user();
        if($user->id_role==6){
            $imunisasi = Imunisasi::with(['getUser'=> function($query) { $query->select('id','nama');},
                                        'getSekolah'=>function($query) {$query->select('nama');},])->where('validasi', 0)->get();
        }
        else{
            $siswa = $user->users()->select('users.id')->where('id_role', 1)->get();
            $listSiswa = [];
            foreach($siswa as $unit){
                array_push($listSiswa, $unit->id);
            }
            
            $imunisasi = Imunisasi::whereIn('id_user', $listSiswa)->with(['getUser'=> function($query) { $query->select('id','nama');},
                                        'getSekolah'=>function($query) {$query->select('nama');},])->where('validasi', 0)->get();
        }
        return view('profil.validasi', ['imunisasi' => $imunisasi]);
    }

    public function validasiImunisasi($id){
        $imunisasi = Imunisasi::where('id_user',$id)->first();
        $imunisasi->validasi = 1;
        
        $imunisasi->save();

        return redirect()->action('ImunisasiController@validasi')->with('success', 'Data Imunisasi Berhasil Divalidasi');
    }
}
