<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    protected $table = 'imunisasi';

    protected $fillable = [
        'id',
        'id_user',
        'tanggal',
        'vaksin',
        'dosis',
        'nomor',
        'nama',
        'lokasi',
        'bukti'
    ];

    public function getUser(){
        return $this->belongsTo(User::class, 'id_user');
    }
    public function getSekolah(){
        return $this->belongsToMany('App\User', 'user_pivot', 'id_child', 'id_user', 'id_user')->where('id_role', 2);
    }
}