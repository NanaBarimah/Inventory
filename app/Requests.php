<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'maintenance_type', 'description', 'assigned_to', 'scheduled_for'
    ];

    public function equipment_requests()
    {
        return $this->hasMany('App\Equipment_request');
    }

    public function equipments()
    {
        return $this->belongsToMany('App\Equipment', 'equipment_requests')->withTimestamps();
    }

    public function engineer(){
        return $this->hasOne('App\Admin', 'id', 'assigned_to');
    }
}
