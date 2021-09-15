<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    });

    Route::middleware(['role:Siswa'])->group(function () {
        Route::get('/form', function () {
            return view('form');
        });
    });

    Route::middleware(['role:Siswa,Kota'])->group(function () {
        Route::get('/jenis-form', function () {
            return view('jenisForm');
        });
    });
    
    Route::middleware(['role:Sekolah,Kelurahan,Puskesmas,Kecamatan,Kota'])->group(function () {
        Route::get('/data-siswa', 'DataController@dataSiswa');
        Route::get('/validasi', function () {
            return view('validasi');
        });
    });

    Route::middleware(['role:Kelurahan,Puskesmas,Kecamatan,Kota'])->group(function () {
        Route::get('/data-sekolah', 'DataController@dataSekolah');
    });

    Route::middleware(['role:Puskesmas,Kecamatan,Kota'])->group(function () {
        Route::get('/data-kelurahan', 'DataController@dataKelurahan');        
    });
    
    Route::middleware(['role:Kecamatan,Kota'])->group(function () {
        Route::get('/data-puskesmas', 'DataController@dataPuskesmas');
    });

    Route::middleware(['role:Kota'])->group(function () {
        Route::get('/data-kecamatan', 'DataController@dataKecamatan');
        Route::get('/tambah-form', function () {
            return view('crudForm');
        });
    });
    
    Route::get('/index', function () {
        return view('index');
    });
    
});

// Authentication Routes...
Auth::routes(['register' => false]);