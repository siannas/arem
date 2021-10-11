<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Auth;
use App\User;

class ubahPassController extends Controller
{
    public function update(Request $request){
        $user = Auth::user();
        $check = Hash::check($request->pass_sekarang, $user->password);
        if($check){
            $pass_baru = User::find($user->id);
            if($request->pass_baru_konfirm==$request->pass_baru){
                $pass_baru->password = Hash::make($request->pass_baru);
                $pass_baru->save();
                return redirect('/')->with('success', 'Password Diperbarui');
            }
            else{
                return redirect('/')->with('error', 'Password Baru Tidak Sama');
            }
        }
        else{
            return redirect('/')->with('error', 'Password Lama Tidak Sesuai');
        }
        
        // $request->validate([
        //     'pass_sekarang' => ['required', Hash::check($request->pass_sekarang, $user->password)],
        //     'pass_baru' => ['required'],
        //     'pass_baru_konfirm' => ['same:pass_baru'],
        // ]);

        
        
        return view('welcome');
    }
}
