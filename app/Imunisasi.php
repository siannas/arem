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
}