<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Imunisasi;
use App\User;

class ImunisasiController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->id_role==1){
            $imunisasi = Imunisasi::where('id_user', Auth::user()->id)->get();
            
            return view('profil.imunisasi', ['imunisasi' => $imunisasi]);
        }
        elseif($user->id_role==4){
            
            $imunisasi = Imunisasi::with(['getUser'=> function($query) { $query->select('id','nama');},
                                        'getSekolah'=>function($query) {$query->select('nama');},])->get();
            

            return view('profil.validasi', ['imunisasi' => $imunisasi]);
        }
    }

    public function store(Request $request){
        
        // Simpan data imunisasi baru
        $imunisasi_baru = new Imunisasi($request->all());
        $imunisasi_baru->id_user = Auth::user()->id;
        $imunisasi_baru->validasi = 0;
        
        $imunisasi_baru->save();

        return redirect()->action('ImunisasiController@index')->with('success', 'Data Imunisasi Berhasil Ditambahkan, Silahkan Tunggu Verifikasi Dari Puskesmas');
    }
}
