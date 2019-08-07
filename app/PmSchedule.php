<?php

namespace App;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PmSchedule extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'title', 'due_date', 'endDueDate', 'department_id', 'unit_id', 
        'rescheduledBasedOnCompleted', 'priority_id', 'description', 'recorded_by'
    ];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function unit()
    {
        return $this->belongsTo('App\Unit');
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function preventive_maintenances()
    {
        return $this->hasMany('App\PreventiveMaintenance');
    }

    public function assets()
    {
        return $this->belongsToMany('App\Asset', 'asset_pm_schedules', 'pm_schedule_id', 'asset_id')->withTimestamps();
    }

    public function actions()
    {
        return $this->hasMany('App\PmAction');
    }
    
    public function asset_category()
    {
        return $this->belongsTo('App\AssetCategory');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
