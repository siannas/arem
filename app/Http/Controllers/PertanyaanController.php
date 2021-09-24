<?php

namespace App\Http\Controllers;

use Validator;
use App\Pertanyaan;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;

class PertanyaanController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, \App\Formulir $formulir)
    {
        $pertanyaan_baru = new Pertanyaan([
            "judul"=> "Belum ada judul",
            'json' => json_encode(
                [
                    "judul"=> "Belum ada judul",
                    "gambar-petunjuk" => null,
                    "pertanyaan" => null
                ]
            )
        ]);

        $pertanyaan_baru->formulir()->associate($formulir);

        $pertanyaan_baru->save();

        return $pertanyaan_baru;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $judul = $pertanyaan->judul;
        $pertanyaan = json_decode($pertanyaan->json);
        return view('form.crudForm', ['id_pertanyaan'=>$id, 'judul' => $judul , 'pertanyaan' => $pertanyaan]);
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
        $pertanyaan = Pertanyaan::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'judul' => 'required_without_all:json',
            'json' => 'required_without_all:judul',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $pertanyaan->fill($request->all());

        $pertanyaan->save();

        return $pertanyaan;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pertanyaan = Pertanyaan::findOrFail($id);
        $id_form = $pertanyaan->id_formulir;
        $pertanyaan->delete();
        return redirect()->action('FormulirController@show', $id_form)->with('success', 'Data Berhasil Dihapus');;
    }
}
