<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    protected $fillable = [
        'role_id', 'model_type','model_id'
    ];


    public function role(){
        return $this->belongsTo('App\Role',"role_id","id");
    }
}
