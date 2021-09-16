<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DataController extends Controller
{
    public function dataSiswa(){
        $dataSiswa = User::where('id_role', 1)->get();

        return view('dataSiswa', ['dataSiswa' => $dataSiswa]);
    }
    public function detailSiswa($id){
        $detailSiswa = User::findOrFail($id);

        return view('detailSiswa', ['siswa' => $detailSiswa]);
    }

    public function dataSekolah(){
        $dataSekolah = User::where('id_role', 2)->get();

        return view('dataSekolah', ['dataSekolah' => $dataSekolah]);
    }
    public function dataKelurahan(){
        $dataKelurahan = User::where('id_role', 3)->get();

        return view('dataKelurahan', ['dataKelurahan' => $dataKelurahan]);
    }
    public function dataPuskesmas(){
        $dataPuskesmas = User::where('id_role', 4)->get();

        return view('dataPuskesmas', ['dataPuskesmas' => $dataPuskesmas]);
    }
    public function dataKecamatan(){
        $dataKecamatan = User::where('id_role', 5)->get();

        return view('dataKecamatan', ['dataKecamatan' => $dataKecamatan]);
    }
}
