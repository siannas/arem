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
use Illuminate\Support\Facades\Validator;
use \Illuminate\Routing\RouteCollection;

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
            'for'=>$for,
            'id_formulir'=>$id,
        ]);
    }

    public function getSiswaByJawaban(Request $request, $id){
        $data = $request->validate([
            'for' => 'required|integer|',
            'idpertanyaan' => 'required',
            'opsi' => 'required',
            'gender' => 'required',
        ]);

        $formulir = Formulir::findOrFail($id);
        $user=\App\User::findOrFail($data['for']);

        //cek apakah formulir khusus anak SD
        $isSD= ($formulir->kelas === '1,2,3,4,5,6'? TRUE: FALSE);

        // ambil sekolah yg termasuk
        if($user->id_role===6){
            $filter = User::where('id_role','2')
                ->select('id')
                ->get();
        }else if($user->id_role===2){
            $filter = [$user];
        }else{
            $filter = \DB::table('user_pivot AS a')
                ->join('users AS u', 'u.id', '=', 'a.id_child')
                ->select('u.id')
                ->where('u.id_role','2')
                ->where('a.id_user',$user->id)
                ->where(function($q) use($isSD) {
                    $q->where('u.kelas',($isSD?'=':'>'),'1')
                    ->orWhere('u.kelas', NULL);
                })
                ->get();            
        }
        $resHTML='';
        foreach ($filter as $s) {
            $fileName = "rekap/rekap_{$s->id}_{$id}_{$data['idpertanyaan']}_{$data['opsi']}_{$data['gender']}.txt";
            if(Storage::exists($fileName)){
                $txt=Storage::get($fileName);
                $res=preg_split('/\r\n|\r|\n|,/', $txt);
                for ($i=0; $i < count($res)/2; $i++) { 
                    $rut=route('data.skrining.siswa', ['id_formulir'=>$id,'id_user'=>$res[$i*2+1]]);
                    $resHTML.="<tr><td><a target=\"_blank\" href=\"".$rut."\">{$res[$i*2]}</a></td><td width=\"60px\"><a target=\"_blank\" href=\"".$rut."\" class=\"btn btn-sm btn-light\"><i class=\"fas fa-fw fa-eye\"></i></a></td></tr>";
                }
            }
        }
        return $resHTML;
    }

    public function download(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'for' => 'required|exists:users,id'    // id sekolah
        ]);
        $data = $validator->validated();
        $formulir = Formulir::findOrFail($id);

        //cek apakah formulir khusus anak SD
        $isSD= ($formulir->kelas === '1,2,3,4,5,6'? TRUE: FALSE);

        //dapatin user dari 'for' sekaligus data rekapnya
        $user = User::where('id', $data['for'])->select('id','nama','id_role')->first();

        // Cari Data Rekap
        if(!$user or $user->id_role === 1){     //jika for siswa maka skip
            return back();
        }elseif ($user->id_role > 2) {

            // jika akun dinkes ambil semua data rekap tanpa terkecuali
            if($user->id_role===6){
                $rekaps= \App\User::where('id_role', '=', '4')    //idrole puskesmas
                    ->with(['users'=>function($q) use($id){
                        $q
                        ->leftJoin('rekap AS r', 'users.id', '=', 'id_sekolah')  
                        ->select('users.id', 'users.nama', 'users.kelas', 'r.id_sekolah','r.csv_gabungan','r.L','r.P')
                        ->where('id_formulir', $id)
                        ->where('id_role',2);
                    }])
                    ->get();
                // $rekaps= \App\UserPivot::join('users AS u', 'u.id', '=', 'id_child')
                //     ->rightJoin('rekap', 'u.id', '=', 'id_sekolah')
                //     ->select('u.id', 'u.nama', 'u.kelas', 'rekap.*')
                //     ->where('u.id_role', '=', '2')
                //     ->where('id_formulir', $id)
                //     ->get();
            }else{
                $rekaps= \App\UserPivot::join('users AS u', 'u.id', '=', 'id_child')
                    ->rightJoin('rekap', 'u.id', '=', 'id_sekolah')
                    ->select('u.id', 'u.nama','u.kelas', 'rekap.*')
                    ->where('u.id_role', '=', '2')
                    ->where('id_user', $user->id)
                    ->where('id_formulir', $id)
                    ->get();
            }
        }else{
            //jika berdasar sekolah
            $rekaps= \App\User::rightJoin('rekap', 'users.id', '=', 'id_sekolah')
                ->select('users.id', 'users.nama','users.kelas', 'rekap.*')
                ->where('id_sekolah', $user->id)
                ->where('id_formulir', $id)
                ->get();
        }

        if($rekaps->isEmpty()){
            return redirect()->back()->with( ['error' => 'Belum ada data rekap yang masuk pada '.$berdasar->nama] );
        }

        //list json simpulan yg ada
        $simpulans = $formulir->pertanyaan()->select('json_simpulan','judul')->get();

        $maxIdx=0;
        $ex = $this->initExcelSimpulan($formulir, $simpulans, $user, $maxIdx, 6, $isSD ? 1 : 7 ); // 6 kelas per jenis formulir (SD dan SMP/SMA)

        if ($user->id_role===6) {
            $this->processExcelSimpulanDinas($rekaps, $ex, $maxIdx);
        }
        else{
            $this->processExcelSimpulan($rekaps, $ex);
        }

        $fileName="Rekap {$formulir->tahun_ajaran} {$user->nama}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($ex, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    private function processExcelSimpulan(&$rekaps, &$ex){
        $jumlahSekolah=count($rekaps);
        $maxIdx=0;
        // SECTION - Generate Excel Rekap
        foreach ($rekaps as $k => $r) {
            $kelas=intval($r->kelas);
            $csv_gabungan[]=explode(',',$r->csv_gabungan);

            //dapatkan jumlah siswa total sekolah
            $stats= \App\UserPivot::rightJoin('users AS u', 'u.id', '=', 'id_child')
                ->leftJoin('profil AS p','p.id_user','=','u.id')
                // ->selectRaw('COUNT(u.id) AS jumlah, p.gender, u.kelas, CONCAT("L", u.kelas) as kunci')
                ->selectRaw('COUNT(u.id) AS jumlah, p.gender, u.kelas, CONCAT(p.gender, u.kelas) as kunci')  //pakai ini haruse
                ->where('user_pivot.id_user', $r->id_sekolah)
                ->groupBy('p.gender','u.kelas')
                ->get()->keyBy('kunci');

            $csv=explode('\n', $r->csv);
            foreach ($csv as $i=>$c) {

                $s_count=0;
                $csv[$i]=explode(',', $c);
                $curKelas=strval($kelas+$i);
                $ac =$ex->getSheetByName('Kelas '.$curKelas);

                // fill nomor dan nama sekolah
                $ac->getCellByColumnAndRow(1, $k+10)->setValue($k+1);
                $ac->getCellByColumnAndRow(2, $k+10)->setValue($r['nama']);
                
                //fill jumlah sekolah
                $ac->getCellByColumnAndRow(3, $k+10)->setValue($jumlahSekolah);
                $ac->getCellByColumnAndRow(4, $k+10)->setValue($jumlahSekolah);

                // fill jumlah siswa di sekolah
                $L=0;
                $P=0;
                if($stats->has('L'.$curKelas)){
                    $L=$stats['L'.$curKelas]->jumlah;
                    $ac->getCellByColumnAndRow(5, $k+10)->setValue($L);
                }
                if($stats->has('P'.$curKelas)){
                    $P=$stats['P'.$curKelas]->jumlah;
                    $ac->getCellByColumnAndRow(6, $k+10)->setValue($P);
                }
                $ac->getCellByColumnAndRow(7, $k+10)->setValue($L+$P);

                // fill jumlah siswa yg terekap formulir
                $ac->getCellByColumnAndRow(8, $k+10)->setValue($r->L);
                $ac->getCellByColumnAndRow(9, $k+10)->setValue($r->P);
                $ac->getCellByColumnAndRow(10, $k+10)->setValue($r->L+$r->P);
                
                //fill csv ke excel
                $maxIdx=count($csv[$i])/2;  // dibagi 2 karena csv nya Laki,perempuan
                for ($j=0; $j < $maxIdx; $j++) { 
                    $val=$csv[$i][$j*2]+$csv[$i][$j*2+1];
                    $cell = $ac->getCellByColumnAndRow($s_count+11, $k+10); //start dari row 10
                    $cell->setValue($val);
                    $s_count++;
                }
            }
        }
        // END of SECTION - Generate Excel Rekap

        //styling excel
        $this->stylingExcelSimpulan($ex,$jumlahSekolah,$maxIdx);
    }

    private function processExcelSimpulanDinas(&$rekaps, &$ex, &$maxIdx){
        $jumlahPuskesmas=count($rekaps);
        // SECTION - Generate Excel Rekap
        foreach ($rekaps as $k => $r) {

            $csv=array_fill(0, $maxIdx*2, 0);
            $data=['L'=>0,'P'=>0];
            $stats=['L'=>0,'P'=>0];
            foreach ($r->users as $r2) {
                if(isset($r2->csv_gabungan)){
                    $csv2=explode(',',$r2->csv_gabungan);
                    $data['L']+=$r2->L;
                    $data['P']+=$r2->P;

                    //sum csv gabungan
                    array_walk($csv2, function($item, $key) use (&$csv){
                        $csv[$key]+= $item;
                    });
                }
                //dapatkan jumlah siswa total sekolah
                $stats2= \App\UserPivot::rightJoin('users AS u', 'u.id', '=', 'id_child')
                    ->leftJoin('profil AS p','p.id_user','=','u.id')
                    // ->selectRaw('COUNT(u.id) AS jumlah, p.gender, "L" as kunci')
                    ->selectRaw('COUNT(u.id) AS jumlah, p.gender, p.gender as kunci')  //pakai ini haruse
                    ->where('user_pivot.id_user', $r2->id)  //id sekolah tersebut
                    ->groupBy('p.gender')
                    ->get()->keyBy('kunci');
                $stats['L']+=$stats2->has('L')?$stats2['L']->jumlah:0;
                $stats['P']+=$stats2->has('P')?$stats2['P']->jumlah:0;
            }

            $s_count=0;
            $ac =$ex->getSheetByName('Rekap');

            // fill nomor dan nama sekolah
            $ac->getCellByColumnAndRow(1, $k+10)->setValue($k+1);
            $ac->getCellByColumnAndRow(2, $k+10)->setValue($r['nama']);
            
            //fill jumlah sekolah
            $ac->getCellByColumnAndRow(3, $k+10)->setValue($jumlahPuskesmas);
            $ac->getCellByColumnAndRow(4, $k+10)->setValue($jumlahPuskesmas);

            // fill jumlah siswa di sekolah
            $L=$stats['L'];
            $ac->getCellByColumnAndRow(5, $k+10)->setValue($L);
            $P=$stats['P'];
            $ac->getCellByColumnAndRow(6, $k+10)->setValue($P);
            $ac->getCellByColumnAndRow(7, $k+10)->setValue($L+$P);

            // fill jumlah siswa yg terekap formulir
            $ac->getCellByColumnAndRow(8, $k+10)->setValue($data['L']);
            $ac->getCellByColumnAndRow(9, $k+10)->setValue($data['P']);
            $ac->getCellByColumnAndRow(10, $k+10)->setValue($data['L']+$data['P']);
            
            //fill csv ke excel
            for ($j=0; $j < $maxIdx; $j++) { 
                $val=$csv[$j*2]+$csv[$j*2+1];
                $cell = $ac->getCellByColumnAndRow($s_count+11, $k+10); //start dari row 10
                $cell->setValue($val);
                $s_count++;
            }
        }
        // END of SECTION - Generate Excel Rekap

        //styling excel
        $this->stylingExcelSimpulan($ex,$jumlahPuskesmas,$maxIdx);
    }

    private function initExcelSimpulan(&$formulir, &$simpulans, &$user, &$maxIdx, $sheet_cnt, $start_from){
        $ex = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $ac = $ex->getActiveSheet()->setTitle((($user->id_role == 6) ? "Rekap":"Kelas {$start_from}"));
        $ac->getCell('A1')->setValue("LAPORAN KEGIATAN KESEHATAN ANAK USIA SEKOLAH DAN REMAJA DISEKOLAH");
        $ac->getCell('A4')->setValue("TAHUN");
        // $ac->getCell('A5')->setValue("TRIBULAN");

        // $ac->getCell('B5')->setValue(": I (Juli-September 2021)");

        // informasi rekap berdasar
        switch ($user->id_role) {
            case 2:
                $ac->getCell('A3')->setValue("SEKOLAH");
                break;
            case 3:
                $ac->getCell('A3')->setValue("KELURAHAN");
                break;
            case 4:
                $ac->getCell('A3')->setValue("PUSKESMAS");
                break;
            case 5:
                $ac->getCell('A3')->setValue("KECAMATAN");
                break;
            case 6:
                $ac->getCell('A3')->setValue("DINAS");
                break;
        }

        $ac->getCell('B3')->setValue(": ".$user->nama);
        $ac->getCell('B4')->setValue(": {$formulir->tahun_ajaran} (Th 2022)");

        $ac->getCell('G3')->setValue("KOTA");
        $ac->getCell('G4')->setValue("PROVINSI");
        $ac->getCell('G5')->setValue("TAHUN AJARAN");

        $ac->getCell('H3')->setValue(": SURABAYA");
        $ac->getCell('H4')->setValue(": JAWA TIMUR");
        $ac->getCell('H5')->setValue(": ".$formulir->tahun_ajaran );

        $ac->mergeCells('A6:A8');
        $ac->getCell('A6')->setValue("No");
        $ac->mergeCells('B6:B8');
        $ac->getCell('B6')->setValue((($user->id_role == 6) ? "NAMA PUSKESMAS":"NAMA SEKOLAH"));
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

        // make heading
        $s_count=0;
        $pre_count = 0;
        foreach ($simpulans as $s) {
            $pre_count = $s_count;
            $judul=$s['judul'];
            $s = json_decode($s['json_simpulan'], true);
            if (empty($s)===false) {
                foreach ($s as $ss) {
                    $this->makeHeadingSimpulan($ss, $ac, $s_count+11);
                    switch ($ss['tipe']) {
                        case 1:
                            $s_count+=1;
                            break;
                        case 2:
                            $s_count+=1;
                            break;
                        case 3:
                            $s_count+=count($ss['range']);
                            break;
                    }
                }
                $r=6; // baris/row
                //create sub-heading dari simpulan di atas
                $cell = $ac->getCellByColumnAndRow($pre_count+11, $r);
                $cell->setValue($judul);
                $col = $cell->getColumn();
                $col2 = $ac->getCellByColumnAndRow($s_count-1+11, $r)->getColumn();
                $ac->mergeCells($col.$r.':'.$col2.$r);
            }
        }
        $maxIdx=$s_count;

        // heading nomor yg urut
        for ($i=1; $i < $s_count+11; $i++) { 
            $ac->getCellByColumnAndRow($i, 9)->setValue($i);
        }

        // clone sheet sebanyak kelas
        if ($user->id_role != 6) {
            for ($i=$start_from+1; $i < $start_from+$sheet_cnt; $i++) {
                $clonedWorksheet = clone $ac;
                $clonedWorksheet->setTitle("Kelas {$i}");
                $ex->addSheet($clonedWorksheet);
            }
        }

        return $ex;
    }

    private function stylingExcelSimpulan(&$ex, $rowCnt, $colCnt){
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

        $bodyStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $ac = $ex->getSheet(0);
        $col = $ac->getCellByColumnAndRow($colCnt-1+11, 1)->getColumn();

        $sheetCount = $ex->getSheetCount();
        for ($i = 0; $i < $sheetCount; $i++) {
            $ac = $ex->getSheet($i);
            $ac->getColumnDimension('B')->setWidth(25);
            $ac->getStyle('A1:H5')->applyFromArray($titleStyle);
            $ac->getStyle('A6:'.$col.'9')->applyFromArray($headerStyle);
            $ac->getStyle('A9:'.$col.'9')->getFont()->setSize(8);
            $ac->getStyle("A10:{$col}".strval($rowCnt+9))->applyFromArray($bodyStyle);
        }
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

    // add data csv ke Excel
    private function insertSimpulanToRekap(&$s, &$ac, $coll){ //simpulan, active sheet
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

}
