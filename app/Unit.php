<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = [
        'name', 'department_id', 'user_id', 'location', 'phone_number',
    ];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function assets()
    {
        return $this->hasMany('App\Asset');
    }

    public function requests()
    {
        return $this->hasMany('App\Requests');
    }
}
