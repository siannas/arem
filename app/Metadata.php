<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metadata extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'metadata';

    protected $primaryKey = 'key';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
    ];
}
