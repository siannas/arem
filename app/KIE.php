<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KIE extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'kie';

    protected $fillable = [
        'jenjang',
        'kategori',
        'judul',
        'ringkasan',
        'foto',
        'isi',
    ];
}
