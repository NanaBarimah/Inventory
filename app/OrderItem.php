<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id', 'part_id', 'part_name', 'quantity', 'unit_cost', 
    ];

    public function purchase_order(Type $var = null)
    {
        return $this->belongsTo('App\PurchaseOrder');
    }
}
