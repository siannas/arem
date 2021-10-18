<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'profil';

    protected $fillable = [
        'id',
        'id_user',
        'gender',
        'email',
        'telp',
        'alamat',
        'asal',
        'tanggal_lahir',
        'foto'
    ];
}
