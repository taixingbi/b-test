<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Eloquent;
use Illuminate\Database\Eloquent\softDeletes;
use Laravel\Cashier\Billable;

//use Illuminate\Database\Eloquent\SoftDeletingTrait;
//use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable,HasRoles,Billable;
//    use ;

    protected $guard_name ='web';

//    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'email', 'password', 'first_name','last_name','remember_token',"role_id","model_id","model_type"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

//    protected $dates = ['deleted_at'];
//
//    public function orders(){
//        return $this->hasMany('App\Order');
//    }

//    public function roles(){
//        return $this->belongsTo('App\Role');
//    }

    public function percentages(){
        return $this->hasOne('App\AgentPercentageList');
    }

    public function modelHasRole(){
        return $this->hasOne('App\ModelHasRole',"model_id",'id');
    }

}
