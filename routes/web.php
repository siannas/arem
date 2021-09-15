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

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/data-siswa', function () {
    return view('dataSiswa');
});

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

// Authentication Routes...
// Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('/login', 'Auth\LoginController@login')->name('');
// Route::post('/logout','Auth\LoginController@logout')->name('logout');
Auth::routes(['register' => false]);

Route::get('/tes', function () {
    return 'Halaman Tes';
})->middleware('auth');