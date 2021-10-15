<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserPivot extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_pivot';
    
    public $timestamps = false;
}
