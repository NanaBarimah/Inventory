<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $fillable = [
<<<<<<< HEAD
        'hospital_id', 'request_link',
=======
        'hospital_id', 'request_link'
>>>>>>> aa661ade09f65a2f10b09a9d7ab6051be3079c8d
    ];

      /**
    * Get the hospital that has these settings.
    */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }

    public function createLink()
    {
        $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $strcode = strlen($str)-1;
        $id  = '';

        for ($i = 0; $i < 96; $i++) {
                $id .= $str[mt_rand(0, $strcode)]; 
        }
        
        $this->request_link = $id;
    }
}
