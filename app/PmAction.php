<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PmAction extends Model
{
    //
    protected $table = "pm_schedule_actions";
    protected $fillable = ["name"];
}
