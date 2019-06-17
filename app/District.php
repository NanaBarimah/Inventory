<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;
    
    protected $fillable = [
        'name', 'region_id',
    ];

    /**
     * Get the region that contains the district.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    /**
     * Get the hospitals for the district.
     */
    public function hospitals()
    {
        return $this->hasMany('App\Hospital');
    }
}
