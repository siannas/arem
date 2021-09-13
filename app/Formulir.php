<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Formulir extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'formulir';

    protected $fillable = [
        'json',
        'status',
        'kelas',
    ];
}
