<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;
    
    protected $fillable = [
        
    ];

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function fault_category()
    {
        return $this->belongsTo('App\FaultCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function service_vendor()
    {
        return $this->belongsTo('App\Service_Vendor');
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\PurchaseOrder');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'teams', 'additional_workers', 'work_order_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function request()
    {
        return $this->belongsTo('App\Requests');
    }
}
