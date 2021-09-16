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

    Route::middleware(['role:Siswa,Kota'])->group(function () {
        Route::get('/form', function () {
            return view('form.form');
        });
    });

    Route::middleware(['role:Siswa,Kota'])->group(function () {
        Route::get('/jenis-form', function () {
            return view('form.jenisForm');
        });
    });
    
    Route::middleware(['role:Sekolah,Kelurahan,Puskesmas,Kecamatan,Kota'])->group(function () {
        Route::get('/data-siswa', 'DataController@dataSiswa');
        Route::get('/validasi', 'ValidasiController@validasi');
        Route::get('/validasi/{id}', 'ValidasiController@validasiSiswa');
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
        Route::get('/list-form', function () {
            return view('form.listTahunAjaran');
        });
    });
    
    Route::get('/index', function () {
        return view('index');
    });
    
    Route::get('/tambah-form', function () {
        return view('form.crudForm');
    });

    Route::get('/data-siswa/{id}', 'DataController@detailSiswa');
    Route::get('/data-sekolah/{id}', 'DataController@detailSekolah');
});

// Authentication Routes...
Auth::routes(['register' => false]);

Route::resource('/formulir', FormulirController::class)->except([
    'create', 'edit', 
]);
Route::post('_/formulir/duplicate/{id}', 'FormulirController@duplicate');

Route::resource('_/pertanyaan', PertanyaanController::class)->except([
    'index', 'create', 'edit', 'store'
]);
Route::post('_/pertanyaan/{formulir}', 'PertanyaanController@store')->name('pertanyaan.store');