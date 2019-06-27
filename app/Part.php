<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;
    
    protected $fillable = ['name', 'cost', 'part_categories_id', 'hospital_id'];

    public function part_category()
    {
        return $this->belongsTo('App\PartCategory');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'asset_parts')->withTimestamps();
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function purchase_orders()
    {
        return $this->belongsToMany('App\PurchaseOrder', 'part_purchases')->withPivot('part_name', 'quantity', 'unit_cost')->withTimestamps();
    }

    public function work_orders()
    {
        return $this->belongsToMany('App\WorkOrder', 'part_work_orders', 'work_order_id', 'part_id')->withTimestamps();
    }
}
