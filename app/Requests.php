<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $fillable = [
        'title', 'description', 'priority_id', 'image', 'department_id', 'unit_id',
        'asset_id', 'requested_by', 'fileName', 'requester_name', 'requester_number',
        'requester_email', 'reason', 'response',
    ];

    public function approve()
    {
        $this->status = 1;
    }

    public function decline()
    {
        $this->status = 0;
    }

    public function priority()
    {
       return $this->belongsTo('App\Priority');
    }

    public function department()
    {
       return $this->belongsTo('App\Department');
    }

    public function unit()
    {
       return $this->belongsTo('App\Unit');
    }

    public function asset()
    {
       return $this->belongsTo('App\Asset');
    }

    public function user()
    {
       return $this->belongsTo('App\User');
    }
}
