<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class PurchaseOrder extends Model
{
    use SoftDeletes, Notifiable;

    protected $primaryKey = 'id';

    public $incrementing = false;

    public function service_vendor()
    {
        return $this->belongsTo('App\Service_Vendor');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'added_by');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'part_purchases')->withPivot('part_name', 'quantity', 'unit_cost')->withTimestamps();
    }

    public function approve()
    {
        $this->status = 1;
    }

    public function decline()
    {
        $this->status = 0;
    }

    public function order_items()
    {
        return $this->hasMany('App\OrderItem');
    }

    public function work_order()
    {
        return $this->belongsTo('App\WorkOrder');
    }

    public function createLink()
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $strcode = strlen($str)-1;
        $id  = '';

        for ($i = 0; $i < 84; $i++) {
                $id .= $str[mt_rand(0, $strcode)]; 
        }
        
        $this->hash_link = $id;
    }
}
