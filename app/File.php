<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    
    public $incrementing = false;

    protected $fillable = ['name'];

    public function asset()
    {
        return $this->belongsTo('App\Asset');
    }
}
