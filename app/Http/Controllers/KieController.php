<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use App\KIE;
use Auth;

class KieController extends Controller
{
    public function index(){
        $user = Auth::user();
        if($user->id_role!=1){
            $kie = KIE::get(['id','jenjang', 'kategori', 'judul', 'ringkasan', 'foto']);
        }else{
            // utk cari kie bdk jenjang
            if($user->kelas > 0 && $user->kelas < 7 ) $jenjang = '1,2,3,4,5,6';
            elseif($user->kelas > 6 && $user->kelas < 13 ) $jenjang = '7,8,9,10,11,12';
            
            $kie = KIE::where('jenjang', $jenjang)->get(['id','jenjang', 'kategori', 'judul', 'ringkasan', 'foto']);
        }
        return view('kie.index', ['kie' => $kie]);
    }

    public function show($id){
        $kie = KIE::findOrFail($id);
        return view('kie.showKie', ['kie' => $kie]);
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

    public function edit($id){
        $kie = KIE::findOrFail($id);
        $kategori = Kategori::all();
        return view('kie.editKie', ['kie' => $kie, 'kategori' => $kategori]);
    }
    
    public function update(Request $request, $id){
        
        $kie = KIE::findOrFail($id);

        $kie->fill($request->all());

        $kategori = request('kategori');
        // Simpan setiap kategori
        foreach($kategori as $unit){
            try{
                $kategori_baru = new Kategori();
                $kategori_baru->nama_kategori = $unit;
                $kategori_baru->save();
            }catch(\Exception $exception) {}
        }
        $kie->kategori = implode(',', $kategori);
        
        $kie->save();
        
        return redirect()->action('KieController@index')->with('success', 'Data KIE Berhasil Diubah');
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
