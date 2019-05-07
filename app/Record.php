<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Record extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_code', 'user_id', 'description',
    ];

    /**
     * Get the equipment that has these records.
     */
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }


    /**
     * Get the user that has entered these records.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
