<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DataController extends Controller
{
    public function dataSiswa(){
        $dataSiswa = User::where('id_role', 1)->get();

        return view('data.dataSiswa', ['dataSiswa' => $dataSiswa]);
    }
    public function detailSiswa($id){
        $detailSiswa = User::findOrFail($id);
        
        return view('data.detailSiswa', ['siswa' => $detailSiswa]);
    }

    public function dataSekolah(){
        $dataSekolah = User::where('id_role', 2)->get();

        return view('data.dataSekolah', ['dataSekolah' => $dataSekolah]);
    }
    public function detailSekolah($id){
        $detailSekolah = User::findOrFail($id);
        $siswa = User::where('parent', $id)->get();

        return view('data.detailSekolah', ['sekolah' => $detailSekolah, 'siswa' => $siswa]);
    }

    public function dataKelurahan(){
        $dataKelurahan = User::where('id_role', 3)->get();

        return view('data.dataKelurahan', ['dataKelurahan' => $dataKelurahan]);
    }
    public function detailKelurahan($id){
        $detailKelurahan = User::findOrFail($id);
        $sekolah = User::where('parent', $id)->get();

        return view('data.detailKelurahan', ['kelurahan' => $detailKelurahan, 'sekolah' => $sekolah]);
    }

    public function dataPuskesmas(){
        $dataPuskesmas = User::where('id_role', 4)->get();

        return view('data.dataPuskesmas', ['dataPuskesmas' => $dataPuskesmas]);
    }
    public function detailPuskesmas($id){
        $detailPuskesmas = User::findOrFail($id);
        $kelurahan = User::where('parent', $id)->get();

        return view('data.detailPuskesmas', ['puskesmas' => $detailPuskesmas, 'kelurahan' => $kelurahan]);
    }

    public function dataKecamatan(){
        $dataKecamatan = User::where('id_role', 5)->get();

        return view('data.dataKecamatan', ['dataKecamatan' => $dataKecamatan]);
    }
    public function detailKecamatan($id){
        $detailKecamatan = User::findOrFail($id);
        $puskesmas = User::where('parent', $id)->get();

        return view('data.detailKecamatan', ['kecamatan' => $detailKecamatan, 'puskesmas' => $puskesmas]);
    }
}
