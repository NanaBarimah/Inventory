<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use Notifiable, SoftDeletes, HasApiTokens;

    protected $guard = 'admin'; 
    
    protected $primaryKey = 'id';
    protected $keyType = "string";

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'email', 'password', 'region_id', 'role', 'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setPasswordAttribute($password)
    {
        if ( !empty($password) ) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

    /**
     * Get the region that has these admins.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    // App\Model\AdminUser
    public function findForPassport($email)
    {
        return $this->where('email', $email)->first();
        // may be also cheking is_admin flag
        // return $this->where('username', $username)->where('is_admin', 1)->first();
    }

    public function work_orders()
    {
        return $this->hasMany('App\WorkOrder');
    }

    public function equipment()
    {
        return $this->hasMany('App\Equipment');
    }
}
