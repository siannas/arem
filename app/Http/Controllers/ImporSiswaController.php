<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use Illuminate\Http\Exceptions\HttpResponseException;
use Maatwebsite\Excel\Facades\Excel;
use App\User;
use Illuminate\Support\Facades\DB;
use App\UserPivot;

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
        $new_collection = [];
        foreach ($collection as $row) {
            $username = trim($row['nik']);
            $nama = trim($row['nama']);
            $kelas = trim($row['kelas']);
            $row['nik'] = empty($username)? null : $username;
            $row['nama'] = empty($nama) ? null : $nama;
            $row['kelas'] = empty($kelas) ? null : $kelas;

            if(!empty($username) or !empty($nama) or !empty($kelas)){
                $jumlah += 1;

                //jika ada kesalahan 1, maka tidak boleh impor
                if(empty($username) or empty($nama) or empty($kelas)) $boleh_import = false;
                
                // Temp adl array of NIK yg diisi tiap proses loop, shg jika sdh ada NIK di temp == data dobel
                if(!empty($username) and array_key_exists($username, $temp)){
                    $row['double'] = true;
                    $boleh_import = false;
                }else{
                    $temp[$username] = true;
                    $row['double'] = false;
                }
                array_push($new_collection, $row);
            }
        }
        if($jumlah === 0) return redirect()->back()->with( ['error' => 'Data excel kosong'] );

        return redirect()->back()->with( ['siswa' => $new_collection, 'success' => 'Berhasil Mengambil Data', 'boleh_import' => $boleh_import, 'jumlah'=>$jumlah] );
    }

    public function send(Request $request){
        $user = Auth::user();

        // Get semua id parents
        $listRelasi = [];
        $relasi = $user->parents()->get();

        $validator = Validator::make($request->all(), [
            'data'  =>  'required'
        ]);
        
        if ($validator->fails()) {
            return back()->withError($validator->errors()->first('data'));
        }

        $data = json_decode($request->input('data'), true);

        DB::beginTransaction();
        for ($i=0; $i < count($data); $i++) { 
            $d = $data[$i];
            try {
                $siswa = User::create([
                    'username' => $d['nik'],
                    'nama' => $d['nama'],
                    'id_role' => 1,
                    'kelas' => $d['kelas'],
                    'tahun_ajaran' => $user->tahun_ajaran,
                    'password' => Hash::make($d['nik']),
                ]);
        
                //membuat relasi user dengan sekolah
                $siswa->parents()->attach($relasi);
                $siswa->parents()->attach($user);
                
            }catch (\Exception $exception) {
                DB::rollBack();
                return back()->withError("NIK ".$d['nik']." telah didaftarkan");
            }   
        }
        DB::commit();   
        
        return redirect()->back()->with( ['success' => 'Siswa Berhasil Disimpan'] );
    }

    public function tambahSiswa(Request $request){
        
        // Simpan data siswa baru
        $siswa_baru = new User($request->all());
        $siswa_baru->id_role = 1;
        $siswa_baru->password = Hash::make($siswa_baru->username);
        $siswa_baru->tahun_ajaran = Auth::user()->tahun_ajaran;
        
        $siswa_baru->save();

        $id = User::select('id')->where('username', $siswa_baru->username)->first();

        // Memberikan relasi siswa ke parent
        // Get semua id parents
        $listRelasi = [];
        $relasi = Auth::user()->parents()->get();
        foreach($relasi as $unit){
            array_push($listRelasi, $unit->id);
        }
        array_push($listRelasi, Auth::user()->id);
        
        // Simpan setiap id parent dan dipasangkan dengan id siswa
        foreach($listRelasi as $unit){
            $relasi = new UserPivot();
            $relasi->id_user=$unit;
            $relasi->id_child=$id->id;
            $relasi->save();
        }

        return redirect()->action('DataController@dataSiswa')->with('success', 'Data Siswa Berhasil Ditambahkan');
    }
}
