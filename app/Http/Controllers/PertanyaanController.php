<?php

namespace App\Http\Controllers;

use Validator;
use App\Pertanyaan;
use App\Jawaban;
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
                    "pertanyaan" => []
                ]
            )
        ]);

        //cek udah ada jawaban yg masuk
        $total=Jawaban::where('id_formulir',$formulir->id)->count();
        if($total>0){
            return back()->withError('Pertanyaan tidak dapat ditambahkan, sudah ada siswa yang mengisi.');
        }

        $pertanyaan_baru->formulir()->associate($formulir);
        $pertanyaan_baru->save();
        // return dd($pertanyaan_baru);
        return redirect()->action('FormulirController@show', $formulir)->with('success', 'Data Berhasil Ditambahkan');
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
        $id_form = $pertanyaan->id_formulir;
        $simpulan = empty($pertanyaan->json_simpulan) ? [] : json_decode($pertanyaan->json_simpulan);
        $pertanyaan = json_decode($pertanyaan->json);
        $deskripsi = property_exists($pertanyaan, 'deskripsi') ? $pertanyaan->deskripsi : '';        

        //cek udah ada jawaban yg masuk
        $total=Jawaban::where('id_formulir',$id_form)->count();
        return view('form.crudForm', ['id_pertanyaan'=>$id, 'judul' => $judul , 'pertanyaan' => $pertanyaan, 'id_form' => $id_form, 'deskripsi' => $deskripsi, 'simpulan'=>$simpulan, 'total'=>$total ]);
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

        //cek udah ada jawaban yg masuk
        $total=Jawaban::where('id_formulir',$pertanyaan->id_formulir)->count();
        if($total>0){
            throw new HttpResponseException(response()->json(['statusText'=>'Pertanyaan tidak dapat diubah, sudah ada siswa yang mengisi.'], 422));
        }

        $validator = Validator::make($request->all(), [
            'judul' => 'required_without_all:json,json_simpulan',
            'json' => 'required_without_all:judul,json_simpulan',
            'json_simpulan' => 'required_without_all:judul,json',
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

        //cek udah ada jawaban yg masuk
        $total=Jawaban::where('id_formulir',$id_form)->count();
        if($total>0){
            return back()->withError('Pertanyaan tidak dapat dihapus, sudah ada siswa yang mengisi.');
        }

        $pertanyaan->delete();
        return redirect()->action('FormulirController@show', $id_form)->with('success', 'Data Berhasil Dihapus');;
    }

    public function preview(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'json' => 'required',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $json = json_decode($request->input('json'));
        
        $contents = \View::make('form.pertanyaanPreview')->with('json', $json);
        $response = \Response::make($contents, 200);
        $response->header('Content-Type', 'text/plain');
        return $response;
    }
}
