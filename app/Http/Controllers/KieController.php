<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\KIE;

class KieController extends Controller
{
    public function index(){
        $kie = KIE::all();
        return view('kie.index', ['kie' => $kie]);
    }

    public function create(){
        $kategori = Kategori::all();
        return view('kie.createKie', ['kategori' => $kategori]);
    }

    public function store(Request $request){
        $kie_baru = new KIE($request->all());
        $kategori = request('kategori');
        // Simpan setiap kategori
        foreach($kategori as $unit){
            try{
                $kategori_baru = new Kategori();
                $kategori_baru->nama_kategori = $unit;
                $kategori_baru->save();
            }catch(\Exception $exception) {}
        }
        $kie_baru->kategori = implode(',', $kategori);
        
        $kie_baru->save();
        
        return redirect()->action('KieController@index')->with('success', 'Data KIE Berhasil Ditambahkan');
    }

    public function destroy($id){
        try {
            $kie = KIE::findOrFail($id);
            $kie->delete();
        }catch (QueryException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
        return redirect()->action('KieController@index')->with('success', 'Data KIE Berhasil Dihapus');
    }
}
