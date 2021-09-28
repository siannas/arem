<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Formulir;
use App\Pertanyaan;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\QueryException;
use Auth;

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
            foreach($formulir as $unit){
                $kelas = explode(',',$unit->kelas);
                $ada = in_array($id_user->kelas, $kelas);
                
                if($ada==True){
                    array_push($id_form, $unit->id);
                }
            }
            $formulir = Formulir::whereIn('id', $id_form)->get();
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

        return $formulir_baru;
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

        $formulir->save();

        return $formulir;
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
        return redirect()->action('FormulirController@index')->with('success', 'Data Berhasil Dihapus');;
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
        $formulir_baru->pertanyaan()->saveMany($pertanyaan_baru);
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

        return view('form.formGenerated', [ 'formulir' => $formulir, 'allPertanyaan' => $formulir->pertanyaan, 'jawaban' => $jawaban ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOrUpdateJawaban(Request $request, $id)
    {
        $formulir = Formulir::findOrFail($id);
        $user = Auth::user();
        $nama_tabel = $user->getTable();
        $sekolah = $user->parents()->where(["id_role"=>2])->first([$nama_tabel.".id"]);
        
        $validator = Validator::make($request->all(), [
            'json' => 'required'
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $req = $request->all();
        $jawaban = \App\Jawaban::firstOrNew([
            'id_user' => $user->id,
            'id_formulir' => $formulir->id,
        ]);

        $jawaban->fill([
            'id_user_sekolah' => is_null($jawaban->id_user_sekolah) ?  $sekolah->id : $jawaban->id_user_sekolah,
            'json' => $req['json'],
            'validasi' => is_null($jawaban->validasi) ? 0 : $jawaban->validasi
        ]);

        $jawaban->save();

        return $jawaban;
    }
}
