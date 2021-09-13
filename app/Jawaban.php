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
        'data',
        'id_user',
        'id_formulir',
        'json',
    ];
}
