<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes; 

    protected $fillable = [
        'equipment_code', 'maintenance_type', 'maintenance_date',
    ];


    /**
     * Get the schedule that belongs to this equipment
     */
    public function equipment()
    {
        $this->belongsTo('App\Equipment');
    }
}
