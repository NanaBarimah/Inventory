<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'department_id', 'user_id',
    ];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function equipments()
    {
        return $this->hasMany('App\Equipment');
    }


}
