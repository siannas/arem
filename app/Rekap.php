<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'rekap';

    protected $fillable = [
        'id_formulir',
        'id_sekolah',
        'json',
        'csv',
        'csv_gabungan',
        'L',
        'P',
    ];
}
