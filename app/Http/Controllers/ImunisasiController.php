<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class ImunisasiController extends Controller
{
    public function index(){
        $user = Auth::user();

        return view('profil.imunisasi', ['user' => $user]);
    }
}
