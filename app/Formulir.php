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
        'tahun_ajaran',
    ];

    /**
     * Get all of the comments for the Formulir
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pertanyaan()
    {
        return $this->hasMany(Pertanyaan::class, 'id_formulir'); 
    }
}
