<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Formulir;
use Illuminate\Http\Exceptions\HttpResponseException;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formulir = Formulir::all();
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
        $formulir['pertanyaan'] = $formulir->pertanyaan;
        return $formulir;
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
        $formulir = Formulir::findOrFail($id);
        $formulir->delete();
        return $formulir;
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
        return $formulir_baru->pertanyaan()->saveMany($pertanyaan_baru);
    }

}
