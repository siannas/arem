<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengajuan';

    protected $fillable = [
        'id_user',
        'id_user_sekolah',
        'verifikasi',
    ];
    public function getUser(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
