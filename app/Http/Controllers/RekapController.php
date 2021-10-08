<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;
use Illuminate\Support\Facades\Storage;

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

    public function tes($id){
        $formulir = Formulir::findOrFail($id);
        $pertanyaan = Pertanyaan::where('id_formulir', $id)->get();
        $jawaban_raw = Jawaban::where('id_formulir', $id)->first();

        $jawaban = json_decode($jawaban_raw->json, true);

        //inisialisasi json rekap jika belum ada
        $allRes = [];
        foreach( $pertanyaan as $p){
            $res = (object) [];
            $json = json_decode($p->json);
            $res->judul = $p->judul;
            $res->pertanyaan = $json->pertanyaan;
            foreach ($json->pertanyaan as $pp) {
                if($pp->tipe === 3){    //pertanyaan pilgan dengan tambahan jawaban
                    $opsi = [];
                    $tambahan = [];
                    foreach ($pp->opsi as $o) {
                        if(is_object($o)){
                            $opsi[$o->{'0'}] = 0;
                            $tambahan[$o->{'0'}] = $o->{'if-selected'};
                            $tambahan[$o->{'0'}]->jawaban = null;
                        }else{
                            $opsi[$o] = 0;
                        }
                    }
                    $pp->opsi = $opsi;
                    $pp->tambahan = $tambahan;
                }else if($pp->tipe === 2 || $pp->tipe === 4){ //pertanyaan isian atau upload gambar
                    $pp->jawaban = null;
                }
            }
            $allRes[] = $res;
        }
        
        //

        foreach( $allRes as $a){
            foreach ($a->pertanyaan as $aa) {
                switch ($aa->tipe) {
                    case 3:
                        $key = $jawaban[$aa->id];
                        $aa->opsi[$key]+=1;
                        try {
                            if($aa->tambahan[$key]){
                                $id_ = $aa->tambahan[$key]->id;
                                //append to file
                                $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$id_.".html";
                                Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$id_].'" disabled></div>');
                                $aa->tambahan[$key]->jawaban = $formulir->id."_".$id_.".html";
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        break;
                    case 2:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$aa->id].'" disabled></div>');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                    case 4:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        Storage::append($namafile, 'Appended Text');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                }
            }
        }

        dd($allRes);
    }
}
