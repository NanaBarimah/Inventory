<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function service_vendor()
    {
        return $this->belongsTo('App\Service_Vendor');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'part_purchases')->withTimestamps();
    }

    public function approve()
    {
        $this->attribute['status'] = 1;
    }

    public function decline()
    {
        $this->attribute['status'] = 0;
    }

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function work_order()
    {
        return $this->belongsTo('App\WorkOrder');
    }
}
