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
    
    public function unit()
    {
        return $this->hasMany('App\Unit');
    }

    public function departments() 
    {
        return $this->hasMany('App\Department');
    }

    public function asset()
    {
        return $this->hasMany('App\User');
    }

    public function purchase_orders()
    {
        return $this->hasMany('App\PurchaseOrder');
    }

    public function requests()
    {
        return $this->hasMany('App\Requests');
    }

    public function work_orders()
    {
        return $this->hasMany('App\WorkOrder', 'assigned_to');
    }

    public function work_order_teams()
    {
        return $this->belongsToMany('App\WorkOrder', 'teams', 'additional_workers', 'work_order_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function messages()
    {
        return $this->belongsToMany('App\WorkOrder', 'work_order_messages', 'user_id', 'work_order_id')->withPivot('action_taken')->withTimestamps();
    }
}
