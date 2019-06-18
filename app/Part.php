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
}
