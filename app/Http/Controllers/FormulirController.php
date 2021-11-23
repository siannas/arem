<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Formulir;
use App\Jawaban;
use App\Pertanyaan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\QueryException;
use Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user= Auth::user();
        if($id_user->id==1){
            $formulir = Formulir::all();
        }
        else{
            $formulir = Formulir::all();
            $id_form = [];

            // Cek siswa masuk dalam kategori mana
            foreach($formulir as $unit){
                $kelas = explode(',',$unit->kelas);
                $ada = in_array($id_user->kelas, $kelas);
                
                if($ada==True){
                    array_push($id_form, $unit->id);
                }
            }
            $riwayatJawaban = Jawaban::where('id_user', $id_user->id)->where('validasi_sekolah', 1)->get();
            $idRiwayat = [];
            foreach($riwayatJawaban as $unit){
                array_push($idRiwayat, $unit->id_formulir);
            }
            $formulir = Formulir::where('status', 1)->whereNotIn('id', $idRiwayat)->whereIn('id', $id_form)->get();
            $riwayat = Formulir::whereIn('id', $idRiwayat)->get();

            return view('form.listTahunAjaran', ['formulir' => $formulir, 'riwayat' => $riwayat]);
        }
        return view('form.listTahunAjaran', ['formulir' => $formulir]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kelas' => 'required',
            'tahun_ajaran' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $formulir_baru = new Formulir($request->all());
        $formulir_baru->status = 0;

        $formulir_baru->save();

        return redirect()->action('FormulirController@index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formulir = Formulir::findOrFail($id);
    
        $pertanyaan = $formulir->pertanyaan;
        return view('form.jenisForm', ['formulir' => $formulir, 'pertanyaan' => $pertanyaan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $formulir = Formulir::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => 'required_without_all:kelas,tahun_ajaran',
            'kelas' => 'required_without_all:status,tahun_ajaran',
            'tahun_ajaran' => 'required_without_all:status,kelas',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $formulir->fill($request->all());
        $formulir->fill(['status'=> $request->input('status')==='on'? 1 : 0]);

        $formulir->save();

        return redirect()->action('FormulirController@index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $formulir = Formulir::findOrFail($id);
            $formulir->delete();
        }catch (QueryException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('FormulirController@index')->with('success', 'Data Berhasil Dihapus');
    }

    /**
     * Duplicate the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function duplicate($id)
    {
        $formulir = Formulir::findOrFail($id);
        $pertanyaan = $formulir->pertanyaan;

        foreach ($pertanyaan as $key => $p) {
            $pertanyaan_baru[] = $p->replicate();
        }

        $formulir_baru = $formulir->replicate()->fill([
            'status' => 0
        ]);

        $formulir_baru->save();
        if(empty($pertanyaan_baru) === false){
            $formulir_baru->pertanyaan()->saveMany($pertanyaan_baru);
        }        
        return redirect()->action('FormulirController@index')->with('success', 'Data Berhasil Diduplikat');;
    }

    public function generate($id){
        $user = Auth::user();
        try{
            $formulir = Formulir::findOrFail($id);
            $jawaban = \App\Jawaban::where('id_user', $user->id)
                                        ->where('id_formulir', $id)->first();
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('form.formGenerated', ['user'=>$user, 'formulir' => $formulir, 'allPertanyaan' => $formulir->pertanyaan, 'jawaban' => $jawaban ]);
    }

    public function generate_4_puskesmas($id_formulir,$id_user){
        $jawaban = Jawaban::where([['id_user', $id_user],['id_formulir',$id_formulir]])->first();

        try{
            $siswa = \App\User::where('id', $id_user)->first();
            $formulir = Formulir::where('id', $id_formulir)->first();
            $pertanyaan = $formulir->pertanyaan;
        }catch(QueryException $exception){
            return back()->withError($exception->getMessage())->withInput();
        }
        return view('form.formGenerated', ['user'=>$siswa, 'siswa' => $siswa, 'formulir' => $formulir, 'allPertanyaan' => $pertanyaan, 'jawaban'=>$jawaban ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateJawaban(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'json' => 'required',
            'user' => 'required'
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $user_id = $request->input('user');
        $formulir = Formulir::findOrFail($id);
        $user = \App\User::findOrFail($user_id);
        $nama_tabel = $user->getTable();
        $sekolah = $user->parents()->where(["id_role"=>2])->first([$nama_tabel.".id"]);

        $req = $request->all();
        $jawaban = \App\Jawaban::firstOrNew([
            'id_user' => $user->id,
            'id_formulir' => $formulir->id,
        ]);
        
        $jawaban->fill([
            'id_user_sekolah' => is_null($jawaban->id_user_sekolah) ?  $sekolah->id : $jawaban->id_user_sekolah,
            'json' => $req['json'],
            'validasi_puskesmas' => is_null($jawaban->validasi_puskesmas) ? 0 : $jawaban->validasi_puskesmas,
            'validasi_sekolah' => is_null($jawaban->validasi_sekolah) ? 0 : $jawaban->validasi_sekolah,
            'status_rekap' => is_null($jawaban->status_rekap) ? 0 : $jawaban->status_rekap,
            'keterangan' => is_null($jawaban->keterangan) ? '' : $jawaban->keterangan,
        ]);

        $jawaban->save();

        return $jawaban;
    }

    public function pertanyaanFormulir($id){
        try{
            $formulir = Formulir::findOrFail($id);
        }catch(\Exception $exception){
            return abort(404);
        }
        return $formulir->pertanyaan;
    }

    public function downloadTemplateIsiDataSkrining(Request $request){
        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'formulir' => 'required|string',
            'pertanyaan' => 'required',
            'sekolah' => 'required|string'
        ]);

        $data = json_decode( $request->input('data'));
        $pertanyaan = json_decode( $request->input('pertanyaan'));
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $ex = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $ex->getProperties()->setCreator("IT Dinkes 2021");
        $ac = $ex->getActiveSheet();

        $ac->getCell('A1')->setValue(explode('_',json_decode($request->input('formulir')))[0]);

        $ac->getCell('A2')->setValue("Nama");
        // $ac->mergeCells('A1:A2');
        $ac->getCell('B2')->setValue("NIK");
        // $ac->mergeCells('B1:B2');

        $ac->getCell('A3')->setValue("1");
        $ac->getCell('B3')->setValue("2");

        $maxcol=2;
        //header pertanyaan dan kode
        foreach ($pertanyaan as $i=>$val) {
            $maxcol++;
            $p=explode('_',$val);
            $cell = $ac->getCellByColumnAndRow($i+3, 1);
            $cell->setValue($p[0]);
            $cell = $ac->getCellByColumnAndRow($i+3, 2);
            $cell->setValue($p[1]);
            $cell = $ac->getCellByColumnAndRow($i+3, 3);
            $cell->setValue($maxcol);
        }

        //daftar siswa
        for ($i=0; $i < count($data[0]); $i++) { 
            $nik=$data[0][$i];
            $nama=$data[1][$i];
            $cell = $ac->getCellByColumnAndRow(1, $i+4);
            $cell->setValue($nama);
            $cell = $ac->getCellByColumnAndRow(2, $i+4);
            $cell->setValue($nik);
            $ac->getColumnDimension($cell->getColumn())->setWidth(15);
        }

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

        $ac->getColumnDimension('A')->setWidth(25);
        $ac->getColumnDimension('B')->setWidth(25);

        //kita hide row satu yg berisikan data id formulir, banyak "siswa_pertanyaan" , dan id-id pertanyaan
        $ac->getRowDimension('1')->setVisible(false);
        $ac->getRowDimension('2')->setRowHeight(30);

        $cell = $ac->getCellByColumnAndRow(count($pertanyaan)+2, count($data[0])+3);
        $maxcol = $cell->getColumn();
        $maxrow = $cell->getRow();

        //Informasi Jumlah siswa, dan jumlah pertanyaan pada file excel, untuk mempermudah proses import nantinya
        $ac->getCell('B1')->setValue(count($data[0]).'_'.count($pertanyaan));

        $ac->getStyle('A1:'.$maxcol.$maxrow)->applyFromArray($headerStyle);
        $ac->getStyle('A3:'.$maxcol.'3')->getFont()->setSize(8);
        $ac->getStyle('A4:A'.$maxrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $ac->getStyle('B4:B'.$maxrow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

        $sekolah = \App\User::select('id','nama')->where('id',explode('_',json_decode($request->input('sekolah')))[0])->first();
        $fileName="INPUT_{$sekolah->nama}.xlsx";
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        header('Cache-Control: max-age=0');
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($ex, 'Xlsx');
        $writer->save('php://output');
        exit;
    }

    public function importIsiDataSkrining(Request $request){
        $validator = Validator::make($request->all(), [
            'file'  =>  'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        
        if ($validator->fails()) {
            return back()->withError($validator->errors()->first('file'));
        }

        $ex = \PhpOffice\PhpSpreadsheet\IOFactory::load($request->file('file'));
        $ac = $ex->getActiveSheet();

        $id_formulir=$ac->getCell('A1')->getValue();
        $temp=explode('_',$ac->getCell('B1')->getValue());
        $cnt=$temp[0];
        $pertanyaan_cnt=$temp[1];

        $cell = $ac->getCellByColumnAndRow($pertanyaan_cnt+2, 1);

        $pertanyaans = $ac->rangeToArray( "C1:{$cell->getColumn()}1",     // The worksheet range that we want to retrieve
                NULL, TRUE, TRUE, FALSE
            )[0];

        for ($i=0; $i < $cnt; $i++) { 
            try {
                $nik=trim($ac->getCellByColumnAndRow(2, $i+4)->getValue());
                $user=\App\User::select('id')->where('username',$nik)->with(['getSekolah'])->first();
                
                $jawaban = \App\Jawaban::firstOrNew([
                    'id_user' => $user->id,
                    'id_formulir' => $id_formulir,
                ]);

                $json=$jawaban->json ? json_decode($jawaban->json, true) : [];
                
                for ($j=0; $j < $pertanyaan_cnt; $j++) {
                    $jwb=trim($ac->getCellByColumnAndRow($j+3, $i+4)->getValue());
                    $json[$pertanyaans[$j]]=trim(str_replace(',','.',$jwb));
                }
                
                $jawaban->fill([
                    'json' => json_encode($json),
                    'id_user_sekolah' => is_null($jawaban->id_user_sekolah) ?  $user->getSekolah[0]->id : $jawaban->id_user_sekolah,
                    'validasi_puskesmas' => is_null($jawaban->validasi_puskesmas) ? 0 : $jawaban->validasi_puskesmas,
                    'validasi_sekolah' => is_null($jawaban->validasi_sekolah) ? 0 : $jawaban->validasi_sekolah,
                    'status_rekap' => is_null($jawaban->status_rekap) ? 0 : $jawaban->status_rekap
                ]);

                $jawaban->save();
            } catch (\Throwable $th) {
                return back()->withError("Terjadi error saat memproses input data NIK {$nik}");
            }
        }

        return redirect()->back()->with( ['success' => 'Input Data Skrining Berhasil Disimpan'] );
    }
}
