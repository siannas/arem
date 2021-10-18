<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Profile;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProfileController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user= Auth::user();
        $profil = \App\Profile::firstOrNew([
            'id_user' => $user->id,
        ]);

        $validator = Validator::make($request->all(), [
            'gender' => 'required_without_all:email,telp,alamat,asal,tanggal_lahir',
            'email' => 'required_without_all:gender,telp,alamat,asal,tanggal_lahir',
            'telp' => 'required_without_all:gender,email,alamat,asal,tanggal_lahir',
            'alamat' => 'required_without_all:gender,email,telp,asal,tanggal_lahir',
            'asal' => 'required_without_all:gender,email,telp,alamat,tanggal_lahir',
            'tanggal_lahir' => 'required_without_all:gender,email,telp,alamat,asal',
        ]);
        
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }

        $profil->fill($request->all());

        $profil->save();

        return back()->with('success', 'Data Berhasil Diubah');
    }
}
