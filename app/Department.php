<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = [
        'name', 'hospital_id', 'user_id', 'location', 'phone_number'
    ];

    public function units()
    {
        return $this->hasMany('App\Unit');
    }

    public function assets()
    {
        return $this->hasMany('App\Asset');
    }
}
