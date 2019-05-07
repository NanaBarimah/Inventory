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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'firstname', 'lastname', 'username', 'password', 'region_id', 'role', 'phone_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $primaryKey = 'id';

    public $incrementing  = false;

    /**
     * Get the region that has these admins.
     */
    public function region()
    {
        return $this->belongsTo('App\Region');
    }

    // App\Model\AdminUser
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
        // may be also cheking is_admin flag
        // return $this->where('username', $username)->where('is_admin', 1)->first();
    }

}
