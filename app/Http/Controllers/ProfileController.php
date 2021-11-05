<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Profile;
use Auth;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(){
        $id = Auth::user()->id;
        $profil = Profile::where('id_user', $id)->first();
        
        return view('profil.profil', ['profil'=>$profil]);
    }
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

        $request->session()->forget('no-profil');
        return back()->with('success', 'Data Berhasil Diubah');
    }

    public function upload(Request $request)
    {
        $user= Auth::user();
        $profil = \App\Profile::firstOrNew([
            'id_user' => $user->id,
        ]);

        $validator = Validator::make($request->all(), [
            'file'  =>  'required|file|mimetypes:image/jpeg,image/png,application/pdf|max:512'
        ]);
        
        if ($validator->fails()) {
            return back()->withError($validator->errors()->first('file'));
        }

        $mime = $request->file('file')->getMimeType();
        $pattern = '/[a-zA-Z]+$/' ;
        preg_match($pattern, $mime, $matches);
        $mime = $matches[0];

        $filename = $user->id.'.'.$mime;
        $path = Storage::putFileAs(
            'photos/',
            $request->file('file'),
            $filename
        );
        
        $url = url('/storage/app/photos/'.$filename);

        $profil->fill(['foto'=>$url]);

        $profil->save();

        $request->session()->forget('no-profil');

        return back()->with('success', 'Data Berhasil Diubah');
    }

    public function deleteFoto(){
        $user = Auth::user();
        $profil = Profile::where('id_user', $user->id)->first();

        $profil->fill(['foto'=>null]);

        $profil->save();

        return back()->with('success', 'Foto Berhasil Dihapus');
    }
}
