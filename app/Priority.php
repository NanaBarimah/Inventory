<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Priority extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = ['name', 'hospital_id'];

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function work_orders()
    {
        return $this->hasMany('App\WorkOrder');
    }
}
