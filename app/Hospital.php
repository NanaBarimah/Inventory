<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

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

    public function priorities()
    {
        return $this->hasMany('App\Priority');
    }

    public function part_categories()
    {
        return $this->hasMany('App\PartCategory');
    }

    public function asset_categories()
    {
        return $this->hasMany('App\AssetCategory');
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

    public function assets()
    {
        return $this->hasMany('App\Asset');
    }

    public function departments()
    {
        return $this->hasMany('App\Department');
    }

    public function parts()
    {
        return $this->hasMany('App\Part');
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\PurchaseOrder');
    }

    public function work_orders()
    {
        return $this->hasMany('App\WorkOrder');
    }
}
