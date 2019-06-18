<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'email', 'role', 'password', 'phone_number', 'job_title', 'hospital_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $primaryKey = 'id';

    public $incrementing  = false;

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * Get the hospital that has these users.
     */
    public function hospital()
    {
        return $this->belongsTo('App\Hospital');
    }
    
    /**
     * Get the records for the user.
     */
    public function records()
    {
        return $this->hasMany('App\Record');
    }


    /**
     * Get the maintenances by the user.
     */
    public function maintenances()
    {
        return $this->hasMany('App\Maintenance');
    }

    // App\Model\User
    public function findForPassport($email)
    {
        return $this->where('email', $email)->first();
    }

    /*public function unit(){
       return $this->belongsTo('App\Unit', 'user_id');
    }*/

    public function asset()
    {
        return $this->belongsTo('App\User');
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\PurchaseOrder');
    }
}
