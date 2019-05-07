<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'serial_number', 'model_number', 'manufacturer_name', 'description', 'category_id', 'unit_id', 'status', 'location', 'year_of_purchase', 'installation_time', 'pos_rep_date', 'equipment_cost', 'service_vendor_cost'
    ];

    public $primaryKey = 'code';

    public $incrementing  = false;

    /**
     * Get the hospital that has these equipment.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    /**
     * Get the category that has these equipment.
     */
    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    
    /**
     * Get the records for the equipment.
     */
    public function records()
    {
        return $this->hasMany('App\Record');
    }


     /**
     * Get the maintenances for the equipment.
     */
    public function maintenances()
    {
        return $this->hasMany('App\Maintenance');
    }

    /**
     * Get the schedules for the equipment
     */
    public function schedules()
    {
        return $this->hasMany('App\Schedule');
    }

    /**
     * Get the unit that has these equipment.
     */
    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function service_vendor(){
        return $this->belongsTo('App\Service_Vendor');
    }

    public function equipment_requests()
    {
        return $this->hasMany('App\Equipment_request');
    }

    public function request()
    {
        return $this->belongsToMany('App\Requests', 'equipment_requests')->withTimestamps();
    }
}
