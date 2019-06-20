<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service_Vendor extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = [
        'name', 'address', 'contact_number', 'contact_name', 'email', 'vendor_type', 'website', 'hospital_id'
    ];

    public $table = "service_vendors";
/* 
    public function equipment()
    {
        return $this->hasMany('App\Equipment');
    }
 */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function assets()
    {
        return $this->hasMany('App\Asset');
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
