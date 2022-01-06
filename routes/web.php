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
    Route::get('/', 'DataController@dashboard');

    Route::middleware(['role:Siswa'])->group(function () {
        Route::post('/pengajuan', 'DataController@pengajuan')->name('dashboard.pengajuan');
    });

    Route::middleware(['role:Siswa,Puskesmas'])->group(function () {
        Route::put('/jawaban/{formulir}', 'FormulirController@storeOrUpdateJawaban')->name('jawaban.store.update');        
    });

    Route::middleware(['role:Sekolah'])->group(function () {
        Route::get('/verifikasi', 'DataController@verifikasi');
        Route::put('/verifikasi/{id}', 'DataController@verifikasiSiswa');
        Route::delete('/verifikasi/tolak/{id}', 'DataController@tolakSiswa');
        
        Route::put('/data-siswa/edit/{id}', 'DataController@editSiswa')->name('siswa.edit');
        Route::put('/naik/{id}', 'DataController@naikKelas')->name('siswa.naik');
        Route::delete('/keluar/{id}', 'DataController@pindahSiswa')->name('siswa.keluar');
    });

    Route::middleware(['role:Siswa,Kota'])->group(function () {
        Route::get('/form', function () {
            return view('form.form');
        });
    });

    Route::middleware(['role:Siswa,Kota'])->group(function () {
        Route::get('/list-form', function () {
            return view('form.listTahunAjaran');
        });
    });

    Route::middleware(['role:Sekolah'])->group(function () {
        Route::post('/resetpassword/{id}', 'DataController@resetPasswordSiswa')->name('admin.resetpassword');
    });

    
    
    Route::middleware(['role:Sekolah,Kelurahan,Puskesmas,Kecamatan,Kota'])->group(function () {
        Route::get('/data-siswa', 'DataController@dataSiswa');
        Route::get('/validasi', 'ValidasiController@index');
        Route::get('/validasi/{id}', 'ValidasiController@validasiSiswa');
        Route::put('/validasi/{id}', 'ValidasiController@validasi')->name('validasi.edit');

        Route::get('/rujukan', 'ValidasiController@rujukan');
        Route::put('/rujukan/{id}', 'ValidasiController@validasiRujukan')->name('validasi.rujukan');

        Route::post('/rekap/download/{id}', 'RekapController@download')->name('rekap.download');
        Route::get('/rekap/siswa/by/jawaban/{id}', 'RekapController@getSiswaByJawaban')->name('rekap.siswa.by.jawaban');
        Route::resource('/rekap', RekapController::class)->except([
            'create', 'edit', 'store'
        ]);
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
        Route::post('/simpan-pengumuman', 'DataController@simpanPengumuman')->name('pengumuman.store');
        Route::get('/tambah-form', function () {
            return view('form.crudForm');
        });
    });

    Route::middleware(['role:Puskesmas'])->group(function () {
        Route::get('/data-skrining/{id_formulir}/{id_user}', 'FormulirController@generate_4_puskesmas')->name('data.skrining.siswa');
        Route::post('/pertanyaan-formulir/import', 'FormulirController@importIsiDataSkrining')->name('formulir.pertanyaan.import');
    });

    Route::get('/data-skrining', 'DataController@dataSiswaDanFormSkrining');
    
    Route::get('/data-siswa/{id}', 'DataController@detailSiswa');
    Route::get('/data-sekolah/{id}', 'DataController@detailSekolah');
    Route::get('/data-kelurahan/{id}', 'DataController@detailKelurahan');
    Route::get('/data-puskesmas/{id}', 'DataController@detailPuskesmas');
    Route::get('/data-kecamatan/{id}', 'DataController@detailKecamatan');

    Route::get('/pertanyaan-formulir/{id}', 'FormulirController@pertanyaanFormulir')->name('formulir.pertanyaan');
    Route::post('/pertanyaan-formulir/filtered', 'DataController@dataSiswaFiltered')->name('formulir.pertanyaan.filtered');

    Route::post('/pertanyaan-formulir/filtered/download', 'FormulirController@downloadTemplateIsiDataSkrining')->name('formulir.pertanyaan.download');
});

// Authentication Routes...
Auth::routes(['register' => false]);

Route::resource('/formulir', FormulirController::class)->except([
    'create', 'edit'
]);
Route::post('/formulir/duplicate/{id}', 'FormulirController@duplicate');

Route::resource('/pertanyaan', PertanyaanController::class)->except([
    'index', 'create', 'edit', 'store'
]);
Route::post('/pertanyaan/add/{formulir}', 'PertanyaanController@store')->name('pertanyaan.store');

Route::post('/pertanyaan/generate/preview', 'PertanyaanController@preview')->name('pertanyaan.preview');

Route::get('/formulir/user/{formulir}', 'FormulirController@generate')->middleware(['hasProfile']);

Route::post('/upload/{id_user}/{id_form}/{id_pertanyaan}', 'FileController@upload')->name('file.upload');

Route::put('/ubah-password', 'ubahPassController@update');

Route::put('/profil/update', 'ProfileController@update')->middleware('auth')->name('profil.update');

Route::get('/profil', 'ProfileController@show')->name('profil.show');

Route::post('/profil/upload', 'ProfileController@upload')->name('profil.upload');

Route::delete('/profil/delete', 'ProfileController@deleteFoto')->name('profil.hapus');

Route::get('/imunisasi', 'ImunisasiController@index');
Route::post('/imunisasi', 'ImunisasiController@store')->name('imunisasi.simpan');
Route::get('/imunisasi/validasi', 'ImunisasiController@validasi');
Route::put('/imunisasi/validasi/{id}', 'ImunisasiController@validasiImunisasi')->name('imunisasi.validasi');

Route::get('/import', 'ImporSiswaController@index')->name('data-siswa.import');
Route::post('/import', 'ImporSiswaController@preview')->name('data-siswa.import.preview');
Route::post('/import/send', 'ImporSiswaController@send')->name('data-siswa.import.send');
Route::post('/data-siswa/tambah', 'ImporSiswaController@tambahSiswa')->name('data-siswa.tambah');

Route::get('kie', 'KieController@index');
Route::get('/kie/create', 'KieController@create');
Route::post('/kie/create', 'KieController@store')->name('kie.store');
Route::get('/kie/edit/{id}', 'KieController@edit');
Route::put('/kie/edit/{id}', 'KieController@update')->name('kie.update');
Route::get('/kie/{id}', 'KieController@show')->name('kie.show');
Route::delete('/kie/{id}', 'KieController@destroy')->name('kie.destroy');