<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentPercentageList extends Model
{
    protected $fillable = [
        'user_id', 'percentage_id'
    ];


    public function percentages(){
        return $this->belongsTo('App\AgentPercentage',"percentage_id","id");
    }
}
