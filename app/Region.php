<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the districts for the region.
     */
    public function districts()
    {
        return $this->hasMany('App\District');
    }

    /**
     * Get the admins for the region.
     */
    public function admins()
    {
        return $this->hasMany('App\Admin');
    }
}
