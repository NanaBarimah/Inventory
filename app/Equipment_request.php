<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment_request extends Model
{
    use SoftDeletes;

    /*public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }

    public function request()
    {
        return $this->belongsTo('App\Requests');
    }*/
}
