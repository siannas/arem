<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;

class KieController extends Controller
{
    public function create(){
        return view('kie.createKie');
    }

    public function store(Request $request){
        return redirect()->action('KieController@index')->with('success', 'Data KIE Berhasil Ditambahkan');
    }
}
