<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCalendar
{

    var $tour_type;
    var $tour_place;
    var $description;
    var $total_people;
    var $start_dateTime;
    var $end_dateTime;

    public function __construct()
    {
//        $type = "";
        $this->total_people = 0;
        $this->description = "";
    }

}
