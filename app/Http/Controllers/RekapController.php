<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;
use App\Jawaban;
use App\Rekap;
use App\User;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RekapController extends Controller
{
    public function index(){
        $rekap = Formulir::all();
        return view('rekap', [ 'rekap' => $rekap ]);
    }

    public function show(Request $request, $id){ //id formulir
        $formulir = Formulir::findOrFail($id);
        $rekaps = [];
        $tulisan = [];
        $berdasar = null;
        $simpulans=null;
        $csv_gabungan=null;
        $hasil_gabungan=null;

        $user= \Auth::user();

        //cek apakah formulir khusus anak SD
        $isSD= ($formulir->kelas === '1,2,3,4,5,6'? TRUE: FALSE);

        // jika akun dinkes tampikkan semua untuk filter
        if($user->id_role===6){
            $filter = User::where('id_role','>','1')
                ->select('id','nama')
                ->get();
        }else{
            $filter = \DB::table('user_pivot AS a')
                ->join('users AS u', 'u.id', '=', 'a.id_child')
                ->select('u.id','u.nama')
                ->where('u.id_role','>','1')
                ->where('a.id_user',$user->id)
                ->where(function($q) use($isSD) {
                    $q->where('u.kelas',($isSD?'=':'>'),'1')
                    ->orWhere('u.kelas', NULL);
                })
                ->get();
            $filter->push($user);
        }

        $for = $request->input('for'); //id user sekolah/kelurahan/puskesmas/kecamatan/dinas

        if(isset($for)){
            //dapatin 1 user sekaligus data rekapnya
            $user = User::where('id', $for)->select('id','nama','id_role')->with(['rekap' => function ($query) use ($id) {
                $query->where('id_formulir', $id);
            }])->first();

            //list json simpulan yg ada
            $simpulans = $formulir->pertanyaan()->select('json_simpulan')->get();
            
            $berdasar=$user;

            if(!$user or $user->id_role === 1){
                return back();
            }elseif ($user->id_role > 2) {

                // jika akun dinkes ambil semua data rekap tanpa terkecuali
                if($user->id_role===6){
                    $rekaps= \App\UserPivot::join('users AS u', 'u.id', '=', 'id_child')
                        ->rightJoin('rekap', 'u.id', '=', 'id_sekolah')
                        ->select('u.id', 'u.nama', 'rekap.*')
                        ->where('u.id_role', '=', '2')
                        ->where('id_formulir', $id)
                        ->get();
                }else{
                    $rekaps= \App\UserPivot::join('users AS u', 'u.id', '=', 'id_child')
                        ->rightJoin('rekap', 'u.id', '=', 'id_sekolah')
                        ->select('u.id', 'u.nama', 'rekap.*')
                        ->where('u.id_role', '=', '2')
                        ->where('id_user', $user->id)
                        ->where('id_formulir', $id)
                        ->get();
                }

            }else{
                $rekaps=$user->rekap;
            }

            if($rekaps->isEmpty()){
                return redirect()->back()->with( ['error' => 'Belum ada data rekap yang masuk pada '.$berdasar->nama] );
            }
            
            foreach ($rekaps as $k => $r) {
                $csv_gabungan[]=explode(',',$r->csv_gabungan);
                $hasil_gabungan[]=json_decode($r->json);
            }
        }

        $pertanyaan = Pertanyaan::where('id_formulir', $id)->get();
        return view('detailRekap', [
            'pertanyaan' => $pertanyaan, 
            'formulir'=>$formulir, 
            'filter'=>$filter, 
            'simpulans'=>$simpulans, 
            'csv_gabungan'=>$csv_gabungan,
            'hasil_gabungan'=>$hasil_gabungan,
            'berdasar'=>$berdasar,
        ]);
    }

    public function show2(Request $request, $id){
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
                }])->whereHas('rekap', function ($query) use ($id) {
                    $query->where('id_formulir', $id);
                })->get();
            }else{
                $sekolahs = [$user];
            }
        }

        if($sekolahs->isEmpty() or $sekolahs[0]->rekap->isEmpty()){
            return redirect()->back()->with( ['error' => 'Belum ada data rekap yang masuk.'] );
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
                        case 1:
                            foreach ($aa->opsi as $key3 => $opsi) {
                                $rekap[$key]->pertanyaan[$key2]->opsi->{$key3} += $curr[$key]->pertanyaan[$key2]->opsi->{$key3};
                            }
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
                    }else if($pp->tipe === 1){ //pertanyaan tipe 1 jaga-jaga
                        $opsi = [];
                        foreach ($pp->opsi as $o) {
                            $opsi[$o] = 0;
                        }
                        $pp->opsi = (object) $opsi;
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
                        $aa->tambahan = (object) $aa->tambahan;
                        try {
                            if($aa->tambahan->{$key}){
                                $id_ = $aa->tambahan->{$key}->id;
                                //append to file
                                $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$id_.".html";
                                Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$id_].'" disabled></div>');
                                $aa->tambahan->{$key}->jawaban = $formulir->id."_".$id_.".html";
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        break;
                    case 1:
                        $key = $jawaban[$aa->id];
                        $aa->opsi->{$key}+=1;
                    case 2:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$aa->id].'" disabled></div>');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                    case 4:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        preg_match('/[^\/]+$/', $jawaban[$aa->id], $matches);
                        $judulGambar = $matches[0];
                        Storage::append($namafile, '<div class="form-group"><a href="'.$jawaban[$aa->id].'" target="_blank" ><input type="text" class="form-control" value="Link: '.$judulGambar.'" readonly style="cursor: pointer;"></a></div>');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                }
            }
        }

        $rekap->fill([ 'json'=>json_encode($allRes) ]);
        $rekap->save();
    }

    private function cekSimpulanTipeFormula(&$j, &$s, &$at){
        $vars=[];
        foreach ($s['vars'] as $k => $v) {
            $vars['/{{'.$k.'}}/']=$j[$v];
        }
        $ma = preg_replace( array_keys($vars), array_values($vars), $s['formula'] );
        $res=eval('return '.$ma.';');        
        foreach ($s['range'] as $v) {
            $compare=explode(',',$v[0]);
            foreach ($compare as $v2) {
                $res2=eval('return '.$ma.$v2.';');
                if($res2){
                    return $v[1];
                }                
            }
            $at+=1;
        }
        return false;
    }

    // membuat heading Excel
    private function makeHeadingSimpulan(&$s, &$ac, $coll){ //simpulan, active sheet
        $r=7;
        switch($s['tipe']){
            case 1:   
                $cell = $ac->getCellByColumnAndRow($coll, $r);
                $cell->setValue($s['field']);
                $c = $cell->getColumn();
                $ac->mergeCells($c.$r.':'.$c.($r+1));
                break;
            case 2:
                $cell = $ac->getCellByColumnAndRow($coll, $r);
                $cell->setValue($s['field']);
                $c = $cell->getColumn();
                $ac->mergeCells($c.$r.':'.$c.($r+1));
                break;
            case 3:
                $at=0;
                foreach ($s['range'] as $v) {
                    $cell = $ac->getCellByColumnAndRow($coll+$at, $r);
                    $cell->setValue($v[1]);
                    $c = $cell->getColumn();
                    $ac->mergeCells($c.$r.':'.$c.($r+1));
                    $at+=1;
                }
                break;
        }
    }


    /**
     * Store a jawaban to rekap sekolah.
     *
     */
    public function excel(){
        $is_new = true;

        $ex = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $ex->getProperties()->setCreator("Maarten Balliauw");
        $ac = $ex->getActiveSheet();
        $ac->getCell('A1')->setValue("LAPORAN KEGIATAN KESEHATAN ANAK USIA SEKOLAH DAN REMAJA DISEKOLAH");
        $ac->getCell('A3')->setValue("PUSKESMAS");
        $ac->getCell('A4')->setValue("TAHUN");
        $ac->getCell('A5')->setValue("TRIBULAN");

        $ac->getCell('B3')->setValue(": SIMOMULYO");
        $ac->getCell('B4')->setValue(": 2021/2022 (Th 2022)");
        $ac->getCell('B5')->setValue(": I (Juli-September 2021)");

        $ac->getCell('G3')->setValue("KOTA");
        $ac->getCell('G4')->setValue("PROVINSI");
        $ac->getCell('G5')->setValue("TAHUN AJARAN");

        $ac->getCell('H3')->setValue(": SURABAYA");
        $ac->getCell('H4')->setValue(": JAWA TIMUR");
        $ac->getCell('H5')->setValue(": 2017/2018");

        $ac->mergeCells('A6:A8');
        $ac->getCell('A6')->setValue("No");
        $ac->mergeCells('B6:B8');
        $ac->getCell('B6')->setValue("NAMA SEKOLAH");
        $ac->mergeCells('C6:C8');
        $ac->getCell('C6')->setValue("Jumlah Sekolah SMA/SMK/MA/SMALB");
        $ac->mergeCells('D6:D8');
        $ac->getCell('D6')->setValue("Jumlah Sekolah SMA/SMK/MA/SMULB yg dijaring");
        $ac->mergeCells('E6:F7');
        $ac->getCell('E6')->setValue("Jumlah sasaran Peserta Didik");
        $ac->getCell('E8')->setValue("L");
        $ac->getCell('F8')->setValue("P");
        $ac->mergeCells('G6:G8');
        $ac->getCell('G6')->setValue("JML");
        $ac->mergeCells('H6:I7');
        $ac->getCell('H6')->setValue("Jumlah Peserta Didik yang di jaring");
        $ac->getCell('H8')->setValue("L");
        $ac->getCell('I8')->setValue("P");
        $ac->mergeCells('J6:J8');
        $ac->getCell('J6')->setValue("JML");
        
        $titleStyle = [
            'font' => [
                'bold' => true,
                'size' => 10,
            ],
        ];

        $headerStyle = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        //## Rekap Simpulan ##//
        $jawaban_raw = Jawaban::findOrFail(17);
        $formulir = Formulir::findOrFail($jawaban_raw->id_formulir);
        // $pertanyaan = Pertanyaan::where('id_formulir', $jawaban_raw->id_formulir)->get();
        $pertanyaan[] = Pertanyaan::find(13);
        $pertanyaan[] = Pertanyaan::find(15);

        $jawaban = json_decode($jawaban_raw->json, true);

        $rs=[];

        $row = 10;

        $s_count = 0;
        $pre_count = 0;
        foreach ($pertanyaan as $k1 => $p) {
            $pre_count = $s_count;
            $simpulan = json_decode($p->json_simpulan, true);

            //cek pada semua simpulan
            foreach ($simpulan as $k2 => $s) {
                if($is_new) $this->makeHeadingSimpulan($s, $ac, $s_count+11);

                switch($s['tipe']){
                    case 1:
                        $id = $s['id'];
                        if (in_array($jawaban[$id], $s['opsi'])) {
                            $rs[$s['field']]=1;
                        }

                        //tambah 1 anak pada kolom dengan field ini
                        $cell = $ac->getCellByColumnAndRow($s_count+11, $row);
                        $val = $cell->getValue();
                        $cell->setValue(empty($val) ? 1 : $val+1);
                        
                        $s_count+=1;
                        break;
                    case 2:
                        //apabila jawab salah satu dari array ini
                        $termasuk = false;
                        for ($i=0; $i < count($s['on']); $i++) { 
                            $item = $s['on'][$i];
                            $id = $item[0];
                            if($jawaban[$id] === $item[1]){
                                $termasuk = true;
                                $rs[$s['field']]=1;
                                break;
                            }
                        }

                        //tambah 1 anak pada kolom dengan field ini
                        $cell = $ac->getCellByColumnAndRow($s_count+11, $row);
                        $val = $cell->getValue();
                        $cell->setValue(empty($val) ? 1 : $val+1);

                        $s_count+=1;
                        break;
                    case 3:
                        $at = 0;
                        $field = $this->cekSimpulanTipeFormula($jawaban, $s, $at);
                        if($field){
                            $rs[$field]=1;
                                //tambah 1 anak pada kolom dengan field ini
                            $cell = $ac->getCellByColumnAndRow($s_count+11+$at, $row);
                            $val = $cell->getValue();
                            $cell->setValue(empty($val) ? 1 : $val+1);
                        }
                        $s_count+=count($s['range']);
                        break;
                }
            }
            if($is_new){
                $r=6;
                //create sub-heading dari simpulan di atas
                $cell = $ac->getCellByColumnAndRow($pre_count+11, 6);
                $cell->setValue($p['judul']);
                $col = $cell->getColumn();
                $col2 = $ac->getCellByColumnAndRow($s_count-1+11, 6)->getColumn();
                
                $ac->mergeCells($col.$r.':'.$col2.$r);
            }
        }
       
        //## END of Rekap Simpulan ##//

        //bikin iterasi angka
        if($is_new){
            
        }

        $col = $ac->getCellByColumnAndRow($s_count-1+11, 1)->getColumn();

        $ac->getColumnDimension('B')->setWidth(25);
        $ac->getStyle('A1:H5')->applyFromArray($titleStyle);
        $ac->getStyle('A6:'.$col.'10')->applyFromArray($headerStyle);
        
        $fileName="tes.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($ex, 'Xlsx');
        $writer->save('php://output');
        exit;
        // $rekap->save();
    }

    public function tes2(){
        // $tes = User::where('id',99)->with(['profil' => function($query) { $query->select('id','gender');}])->first();
        // $tes = User::where('id',99)->with('profil')->first();
        // dd($tes);
        $jawaban_raw = Jawaban::where('id',17)
            ->with([
                'getSekolah' => function($query) { $query->select('id','kelas');},
                'getUser' => function($query) { $query->select('id','kelas');},
                'getUser.profil'
            ])->first();
            
        $kelas = $jawaban_raw->getUser->kelas;
        $gender = $jawaban_raw->getUser->profil->gender;
        $sklh_kelas = $jawaban_raw->getSekolah->kelas;
        
        $formulir = Formulir::findOrFail($jawaban_raw->id_formulir);
        // $pertanyaan = Pertanyaan::where('id_formulir', $jawaban_raw->id_formulir)->get();
        $pertanyaan[] = Pertanyaan::find(13);
        $pertanyaan[] = Pertanyaan::find(15);

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
                    }else if($pp->tipe === 1){ //pertanyaan tipe 1 jaga-jaga
                        $opsi = [];
                        foreach ($pp->opsi as $o) {
                            $opsi[$o] = 0;
                        }
                        $pp->opsi = (object) $opsi;
                    }else if($pp->tipe === 2 || $pp->tipe === 4){ //pertanyaan isian atau upload gambar
                        $pp->jawaban = null;
                    }
                }
                $allRes[] = $res;
            }
        }else{
            $allRes = json_decode($rekap->json, false);
        }

        //SIMPULAN
        $is_new = empty($rekap->csv);
        
        //inisialisasi csv berbentuk array
        if($is_new){ 
            $csv_arr = [];
        }else{
            $csv=explode('\n',$rekap->csv);
            $csv_arr=explode(',',$csv[max($kelas-$sklh_kelas, 0) ]);
        }

        $add = $gender === 'P' ? 1 : 0;

        $s_count = 0;
        $pre_count = 0;
        foreach ($pertanyaan as $k1 => $p) {
            $pre_count = $s_count;
            $simpulan = json_decode($p->json_simpulan, true);

            //cek pada semua simpulan
            foreach ($simpulan as $k2 => $s) {

                switch($s['tipe']){
                    case 1:
                        $id = $s['id'];
                        if($is_new) array_push($csv_arr, 0, 0); //PUSH UNTUK LAKI, PEREMPUAN

                        if (in_array($jawaban[$id], $s['opsi'])) {
                            $csv_arr[$s_count+$add]+=1;
                        }
                        
                        $s_count+=2;
                        break;
                    case 2:
                        if($is_new) array_push($csv_arr, 0, 0); //PUSH UNTUK LAKI, PEREMPUAN
                        //apabila jawab salah satu dari array ini
                        for ($i=0; $i < count($s['on']); $i++) { 
                            $item = $s['on'][$i];
                            $id = $item[0];
                            if($jawaban[$id] === $item[1]){
                                $csv_arr[$s_count+$add]+=1;
                                break;
                            }
                        }

                        $s_count+=2;
                        break;
                    case 3:
                        $range = count($s['range']);
                        if($is_new){   //PUSH UNTUK LAKI, PEREMPUAN
                            $f = array_fill(0,$range*2, 0);
                            $csv_arr = array_merge($csv_arr, $f);
                        }
                        $at = 0;
                        $field = $this->cekSimpulanTipeFormula($jawaban, $s, $at);
                        if($field){
                            //tambah 1 anak pada kolom dengan field ini
                            $csv_arr[$s_count+$add+$at*2]+=1;
                        }
                        $s_count+=($range*2);
                        break;
                }
            }
        }

        //finalisasi array ke csv string
        if($is_new){
            $dummy = array_fill(0,count($csv_arr),0);
            $dummy = implode(',',$dummy);

            if($sklh_kelas===1){    
                $csv = array_fill(0,6,$dummy);
            }else if($sklh_kelas===7 or $sklh_kelas===10){
                $csv = array_fill(0,3,[]);
            }
        }
        $csv[max($kelas-$sklh_kelas, 0) ] = implode(',',$csv_arr);

        $simpulan = implode('\n',$csv);
        //END of SIMPULAN

        foreach( $allRes as $a){
            foreach ($a->pertanyaan as $aa) {
                switch ($aa->tipe) {
                    case 3:
                        $key = $jawaban[$aa->id];
                        $aa->opsi->{$key}+=1;
                        $aa->tambahan = (object) $aa->tambahan;
                        try {
                            if($aa->tambahan->{$key}){
                                $id_ = $aa->tambahan->{$key}->id;
                                //append to file
                                $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$id_.".html";
                                Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$id_].'" disabled></div>');
                                $aa->tambahan->{$key}->jawaban = $formulir->id."_".$id_.".html";
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                        break;
                    case 1:
                        $key = $jawaban[$aa->id];
                        $aa->opsi->{$key}+=1;
                    case 2:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        Storage::append($namafile, '<div class="form-group"><input type="text" class="form-control" value="'.$jawaban[$aa->id].'" disabled></div>');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                    case 4:
                        $namafile = "sekolah/".$jawaban_raw->id_user_sekolah."/".$formulir->id."_".$aa->id.".html";
                        preg_match('/[^\/]+$/', $jawaban[$aa->id], $matches);
                        $judulGambar = $matches[0];
                        Storage::append($namafile, '<div class="form-group"><a href="'.$jawaban[$aa->id].'" target="_blank" ><input type="text" class="form-control" value="Link: '.$judulGambar.'" readonly style="cursor: pointer;"></a></div>');
                        $aa->jawaban = $formulir->id."_".$aa->id.".html";
                        break;
                }
            }
        }

        $rekap->fill([ 'json'=>json_encode($allRes), 'csv'=>$simpulan ]);
        dd($rekap);
    }
}
