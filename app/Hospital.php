<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'address', 'district_id', 'contact_number'
    ];

    /**
     * Get the district that contains the hospitals.
     */
    public function district()
    {
        return $this->belongsTo('App\District');
    }

    /**
     * Get the users for the hospital.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Get the equipment for the hospital.
     */
    public function equipments()
    {
        return $this->hasMany('App\Equipment');
    }

    /**
     * Get the settings for the hospital.
     */
    public function settings()
    {
        return $this->hasMany('App\Setting');
    }
    
    public function services()
    {
        return $this->hasMany('App\Service_Vendor');
    }
}
