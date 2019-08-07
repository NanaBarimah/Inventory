<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = [
        'name', 'equipment_code', 'admin_category_id', 'purchase_price', 'purchase_date', 'image',
        'admin_id', 'status', 'description', 'area', 'serial_number', 'model_number', 'parent_id', 
        'manufacturer_name', 'region_id', 'reason', 'warranty_expiration', 'type',
    ];

    public function parent() 
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() 
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function admin_category() 
    {
        return $this->belongsTo('App\AdminCategory');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function donation()
    {
        return $this->belongsTo('App\Donation');
    }
}
