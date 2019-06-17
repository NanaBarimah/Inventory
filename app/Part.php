<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'cost', 'part_categories_id'];

    public function part_category()
    {
        return $this->belongsTo('App\PartCategory');
    }
}
