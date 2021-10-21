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

        $collection = Excel::ToCollection(new \App\Imports\SiswaImport, $request->file('file'))[0];
        foreach ($collection as $row) {
            $username = trim($row['nik']);
            $nama = trim($row['nama']);
            $row['nik'] = empty($username)? null : $username;
            $row['nama'] = empty($nama) ? null : $nama;

            if(!empty($username) and array_key_exists($username, $temp)){
                $row['double'] = true;
            }else{
                $temp[$username] = true;
                $row['double'] = false;
            }            
        }
        return redirect()->back()->with( ['siswa' => $collection, 'success' => 'Berhasil Mengambil Data'] );
    }
}
