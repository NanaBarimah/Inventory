<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'hospital_id'];

    public function work_orders()
    {
        return $this->hasMany('App\WorkOrder');
    }
}
