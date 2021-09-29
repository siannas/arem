<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;

class RekapController extends Controller
{
    public function index(){
        $rekap = Formulir::all();
        return view('rekap', [ 'rekap' => $rekap ]);
    }

    public function show($id){
        $rekap = Formulir::findOrFail($id)->first();
        $pertanyaan = Pertanyaan::where('id_formulir', $id)->get();
        return view('detailRekap', ['rekap' => $rekap, 'pertanyaan' => $pertanyaan]);
    }
}
