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
        'id', 'firstname', 'lastname', 'username', 'password', 'hospital_id', 'role', 'phone_number', 'api_token'
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
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }

}
