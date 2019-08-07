<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Donation extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'region_id', 'hospital_id', 'date_donated', 'description',
        'presented_by', 'presented_to'
    ];

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function equipment()
    {
        return $this->hasMany('App\Equipment');
    }
}
