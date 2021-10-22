<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Maatwebsite\Excel\Facades\Excel;

class ImporSiswaController extends Controller
{
    public function index(){
        return view('importData');
    }

    public function preview(Request $request){
        $validator = Validator::make($request->all(), [
            'file'  =>  'required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ]);
        
        if ($validator->fails()) {
            return back()->withError($validator->errors()->first('file'));
        }

        $temp = [];
        $boleh_import = true;
        $jumlah = 0;

        $collection = Excel::ToCollection(new \App\Imports\SiswaImport, $request->file('file'))[0];
        foreach ($collection as $row) {
            if(!empty($username) or !empty($nama)) $jumlah += 1;
            
            $username = trim($row['nik']);
            $nama = trim($row['nama']);
            $row['nik'] = empty($username)? null : $username;
            $row['nama'] = empty($nama) ? null : $nama;

            //jika ada kesalahan 1, maka tidak boleh impor
            if(empty($username) or empty($nama)) $boleh_import = false;

            if(!empty($username) and array_key_exists($username, $temp)){
                $row['double'] = true;
                $boleh_import = false;
            }else{
                $temp[$username] = true;
                $row['double'] = false;
            }            
        }
        if($jumlah === 0) return redirect()->back()->with( ['error' => 'Data excel kosong'] );

        return redirect()->back()->with( ['siswa' => $collection, 'success' => 'Berhasil Mengambil Data', 'boleh_import' => $boleh_import, 'jumlah'=>$jumlah] );
    }
}
