<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'nama',
        'id_role',
        'kelas',
        'tahun_ajaran',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getRole(){
        return $this->belongsTo(Role::class, 'id_role');
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'parent'); 
    // }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_pivot', 'id_user', 'id_child');
            // ->withPivot('id_role');
    }

    public function parents()
    {
        return $this->belongsToMany('App\User', 'user_pivot', 'id_child', 'id_user');
            // ->withPivot('id_role');
    }

    public function rekap()
    {
        return $this->hasMany(Rekap::class, 'id_sekolah');
            // ->withPivot('id_role');
    }

    /**
     * Get the profil associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profil()
    {
        return $this->hasOne(Profile::class, 'id_user', 'id');
    }

    public function jawabans()
    {
        return $this->hasMany('App\Jawaban', 'id_user');
    }

    public function getSekolah(){
        return $this->belongsToMany('App\User', 'user_pivot', 'id_child', 'id_user', 'id')->where('id_role', 2);
    }
}
