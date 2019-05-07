<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service_Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'contact_number', 'hospital_id'
    ];

    public $table = "service_vendors";

    public function equipment()
    {
        return $this->hasMany('App\Equipment');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
}
