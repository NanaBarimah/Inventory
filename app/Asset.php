<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = [
        'name', 'asset_code', 'asset_category_id', 'purchase_price', 'purchase_date', 'image',
        'user_id', 'installation_date', 'status', 'availability', 'description', 'area',
        'department_id', 'unit_id', 'pos_rep_date', 'serial_number', 'model_number', 
        'manufacturer_name', 'service_vendor_id', 'hospital_id', 'reason', 'warranty_expiration',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function files()
    {
        return $this->hasMany('App\File');
    }

    public function parts()
    {
        return $this->belongsToMany('App\Part', 'asset_parts')->withTimestamps();
    }

    public function asset_category()
    {
        return $this->belongsTo('App\AssetCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
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
        return $this->belongsTo('App\Service_Vendor', 'service_vendor_id');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function requests()
    {
        return $this->hasMany('App\Requests');
    }
}
