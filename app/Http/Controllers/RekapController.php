<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;

class RekapController extends Controller
{
    public function index(){
        $rekap = Formulir::all();
        return view('rekap', [ 'rekap' => $rekap ]);
    }

    public function show($id){
        $rekap = Formulir::findOrFail($id);
        $pertanyaan = Pertanyaan::where('id_formulir', $id)->get();
        $jawaban = Jawaban::where('id_formulir', $id)->get();
        return view('detailRekap', ['rekap' => $rekap, 'pertanyaan' => $pertanyaan, 'jawaban' => $jawaban]);
    }
}
