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
    
    Route::get('/data-siswa', 'DataController@dataSiswa');
    Route::get('/data-sekolah', 'DataController@dataSekolah');
    Route::get('/data-kelurahan', 'DataController@dataKelurahan');
    Route::get('/data-puskesmas', 'DataController@dataPuskesmas');
    Route::get('/data-kecamatan', 'DataController@dataKecamatan');
    
    Route::get('/validasi', function () {
        return view('validasi');
    });
    
    Route::get('/jenis-form', function () {
        return view('jenisForm');
    });
    
    Route::get('/form', function () {
        return view('form');
    });
    
    Route::get('/index', function () {
        return view('index');
    });
    
    Route::get('/tambah-form', function () {
        return view('crudForm');
    });
});

// Authentication Routes...
Auth::routes(['register' => false]);