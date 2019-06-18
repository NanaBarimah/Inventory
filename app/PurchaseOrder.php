<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use SoftDeletes;

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
}
