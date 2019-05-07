<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'hospital_id', 'user_id',
    ];

      /**
    * Get the hospital that has these settings.
    */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
