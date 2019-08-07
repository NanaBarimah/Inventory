<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminCategory extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = ['name', 'region_id'];

    public function parent() 
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children() 
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    public function equipment() 
    {
        return $this->hasMany('App\Equipment');
    }
}
