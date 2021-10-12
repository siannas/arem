<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;
use App\Rekap;
use App\User;
use Illuminate\Support\Facades\Storage;

class RekapController extends Controller
{
    public function index(){
        $rekap = Formulir::all();
        return view('rekap', [ 'rekap' => $rekap ]);
    }

    public function show(Request $request, $id){
        $formulir = Formulir::findOrFail($id);
        $for = $request->input('for'); //id user sekolah/kelurahan/puskesmas/kecamatan/dinas
        $sekolahs = [];
        $berdasar = null;
        $tulisan = [];
        if($for){
            //dapatin 1 user sekaligus data rekapnya
            $user = User::where('id', $for)->with(['rekap' => function ($query) use ($id) {
                $query->where('id_formulir', $id);
            }])->first();
            $berdasar=$user;

            if(!$user or $user->id_role === 1){
                return back();
            }elseif ($user->id_role > 2) {
                //dapatin semua user sekolah sekaligus data rekapnya
                $sekolahs = $user->users()->where('id_role', 2)->with(['rekap' => function ($query) use ($id) {
                    $query->where('id_formulir', $id);
                }])->get();
            }else{
                $sekolahs = [$user];
            }
        }

        $rekap = json_decode($sekolahs[0]->rekap[0]->json);

        $jml = count($sekolahs);

        if($jml === 1){
            foreach ($rekap as $key => $r) {
                foreach ($r->pertanyaan as $key2 => $aa) {
                    switch ($aa->tipe) {
                        case 3:
                            foreach ($aa->tambahan as $tkey => $t) {
                                $t->jawaban = [$t->jawaban];
                                $tulisan[$t->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$t->jawaban[0]);
                            }
                            break;
                        case 2:
                            $aa->jawaban = [$aa->jawaban];
                            $tulisan[$aa->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$aa->jawaban[0]);
                            break;
                        case 4:
                            $aa->jawaban = [$aa->jawaban];
                            $tulisan[$aa->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$aa->jawaban[0]);
                            break;
                    }
                }
            }            
        }

        for ($i=1; $i < $jml ; $i++) { 
            $curr = json_decode($sekolahs[$i]->rekap[0]->json);
            $sekolah_id = $sekolahs[$i]->id;
            foreach ($rekap as $key => $r) {
                foreach ($r->pertanyaan as $key2 => $aa) {
                    switch ($aa->tipe) {
                        case 3:
                            foreach ($aa->opsi as $key3 => $opsi) {
                                $rekap[$key]->pertanyaan[$key2]->opsi->{$key3} += $curr[$key]->pertanyaan[$key2]->opsi->{$key3};
                            }
                            foreach ($aa->tambahan as $tkey => $t) {
                                if(is_array($t->jawaban) === false){
                                    $t->jawaban = [$t->jawaban];
                                    $tulisan[$t->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$t->jawaban[0]);
                                }
                                $jawaban_baru = $curr[$key]->pertanyaan[$key2]->tambahan->{$tkey}->jawaban;
                                // array_push($t->jawaban, $jawaban_baru);
                                $tulisan[$t->jawaban[0]] .= Storage::get('sekolah/'.$sekolah_id.'/'.$jawaban_baru);
                            }
                            break;
                        case 2:
                            if(is_array($aa->jawaban) === false){
                                $aa->jawaban = [$aa->jawaban];
                                $tulisan[$aa->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$aa->jawaban[0]);
                            }  
                            $jawaban_baru = $curr[$key]->pertanyaan[$key2]->jawaban;
                            // array_push($t->jawaban, $jawaban_baru);                            
                            $tulisan[$aa->jawaban[0]] .= Storage::get('sekolah/'.$sekolah_id.'/'.$jawaban_baru);
                            break;
                        case 4:
                            if(is_array($aa->jawaban) === false){
                                $aa->jawaban = [$aa->jawaban];
                                $tulisan[$aa->jawaban[0]] = Storage::get('sekolah/'.$sekolahs[0]->id.'/'.$aa->jawaban[0]);
                            }  
                            $jawaban_baru = $curr[$key]->pertanyaan[$key2]->jawaban;
                            // array_push($t->jawaban, $jawaban_baru);                            
                            $tulisan[$aa->jawaban[0]] .= Storage::get('sekolah/'.$sekolah_id.'/'.$jawaban_baru);
                            break;
                    }
                }
            }
        }

        $pertanyaan = Pertanyaan::where('id_formulir', $id)->get();
        return view('detailRekap', ['rekap' => $rekap, 'pertanyaan' => $pertanyaan, 'formulir'=>$formulir, 'berdasar'=> $berdasar, 'tulisan'=>$tulisan]);
    }

    /**
     * Store a jawaban to rekap sekolah.
     *
     */
    public function tes($jawaban_id){
        $jawaban_raw = Jawaban::findOrFail($jawaban_id);
        $formulir = Formulir::findOrFail($jawaban_raw->id_formulir);
        $pertanyaan = Pertanyaan::where('id_formulir', $jawaban_raw->id_formulir)->get();

        $jawaban = json_decode($jawaban_raw->json, true);

        $rekap = Rekap::where('id_formulir', $jawaban_raw->id_formulir)->where('id_sekolah', $jawaban_raw->id_user_sekolah)->first();

        if(!$rekap){
            $rekap = new Rekap([
                'id_formulir' => $jawaban_raw->id_formulir,
                'id_sekolah' => $jawaban_raw->id_user_sekolah,
                'json' => null
            ]);

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
                        $pp->opsi = (object) $opsi;
                        $pp->tambahan = $tambahan;
                    }else if($pp->tipe === 2 || $pp->tipe === 4){ //pertanyaan isian atau upload gambar
                        $pp->jawaban = null;
                    }
                }
                $allRes[] = $res;
            }
        }else{
            $allRes = json_decode($rekap->json, false);
        }

        foreach( $allRes as $a){
            foreach ($a->pertanyaan as $aa) {
                switch ($aa->tipe) {
                    case 3:
                        $key = $jawaban[$aa->id];
                        $aa->opsi->{$key}+=1;
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

        $rekap->fill([ 'json'=>json_encode($allRes) ]);
        $rekap->save();
    }
}
