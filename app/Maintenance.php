<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Maintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_code', 'job_number', 'date_reported', 'date_inspected', 'problem_found', 'action_taken', 'faulty_category',
        'recommendation', 'cost', 'mtce_officer', 'type', 'duration', 'down_time', 'reason', 'date_out'
    ];

    
    /**
    * Get the equipment that has these maintenances.
    */
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }


    /**
     * Get the user that has performed these maintenances.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
