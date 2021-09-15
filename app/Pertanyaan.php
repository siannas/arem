<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pertanyaan';

    protected $fillable = [
        'json',
        'id_formulir',
    ];

    /**
     * Get the formulir that owns the Jawaban
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulir()
    {
        return $this->belongsTo(Formulir::class, 'id_formulir'); 
    }
}
