<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PartCategory extends Model
{
    use SoftDeletes;

<<<<<<< HEAD
    protected $primaryKey = "id";
    public $incrementing = false; 
=======
    protected $primaryKey = 'id';
    
    public $incrementing = false;

>>>>>>> 1c0ae6b5ba395a48ea00a5b557b70cda0c0ae30e
    protected $fillable = ['name', 'hospital_id'];

    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function parts()
    {
        return $this->hasMany('App\Part');
    }
}
