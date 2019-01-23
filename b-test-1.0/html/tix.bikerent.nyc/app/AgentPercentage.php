<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentPercentage extends Model
{
    protected $table = "agent_percentages";
    protected $fillable = [
        'percentage_rate','role_id'
    ];



}
