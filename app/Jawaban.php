<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jawaban extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jawaban';

    protected $fillable = [
        'id_user',
        'id_user_sekolah',
        'id_formulir',
        'json',
        'validasi',
        'validasi_sekolah',
        'status_rekap',
        'validasi_puskesmas',
        'keterangan',
    ];
    public function getUser(){
        return $this->belongsTo(User::class, 'id_user');
    }

    public function getSekolah(){
        return $this->belongsTo(User::class, 'id_user_sekolah');
    }

    public function getFormulir(){
        return $this->belongsTo(Formulir::class, 'id_formulir');
    }
}
