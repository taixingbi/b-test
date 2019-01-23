<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Log;
use Google;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class UpdateCalendar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:calendar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update calendar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    private function googleServiceGenerate()
    {
        $client = new \Google_Client();
        $client->setClientId(env("google_client_id"));
        $client->setClientSecret(env("google_client_secret"));

        $client->setAuthConfig(storage_path('/credentials.json'));

        $client->useApplicationDefaultCredentials();
        $client->setScopes([env("google_api_scope")]);
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false)));

        $client->setHttpClient($guzzleClient);


        $service = new \Google_Service_Calendar($client);
        return $service;
    }

    private function getTourType($tour)
    {
        $summary = $tour->tour_place;
        if ($tour->pedicab > 0) {
            $summary .= "Pedicab Tour";
        } elseif ($tour->walking > 0) {
            $summary .= "Walking Tour";
        } else {
            $summary .= "Bike Tour";
        }
        return $summary;
    }


    private function dateTimeGenerate($date, $time, $type)
    {
        if ($type == "start") {
            $sec = 0;
        } else {
            $sec = 7200;
        }
        $date = strtotime($date);
//            dd(date("G:i", strtotime($tour->time)- 14400));
        $time = date("G:i", strtotime($time) + $sec);
        $newdate_format = date('Y-m-d', $date);
        $newdate_format = new DateTime($newdate_format . ' ' . $time);

        $start_dateTime = $newdate_format->format(DateTime::ATOM);
        return $start_dateTime;
    }

    public function handle(){
        $tour_types = ["adult","pedicab",'walking'];
        $times = ['9AM','10AM',"12PM",'1PM','4PM'];
        $tour_places = ["Central Park", "Brooklyn Bridge"];
        foreach ($tour_places as $tour_place) {
            foreach ($tour_types as $type) {
                foreach ($times as $time) {
                    $this->createTourCalendar($tour_place, $type, $time);
                }
            }
        }
    }

    private function createEvent(TourCalendar $tour_obj, $type){
        $service = $this->googleServiceGenerate();
        if($type=="adult") $type = "public(2h)";
        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $tour_obj->tour_place." ".$type,
            'location' => $tour_obj->tour_place,
            'description' => $tour_obj->description,
            'start' => array(
                'dateTime' => $tour_obj->start_dateTime,
                'timeZone' => 'America/New_York',
            ),
            'end' => array(
                'dateTime' => $tour_obj->end_dateTime,
                'timeZone' => 'America/New_York',
            ),
            'colorId' =>"6",

//                'recurrence' => array(
//                    'RRULE:FREQ=DAILY;COUNT=2'
//                ),
            'attendees' => array(
//                array('email' => 'lpage@example.com'),
                array('email' => 'bikerentny@gmail.com'),
            ),
            'reminders' => array(
                'useDefault' => FALSE,
                'overrides' => array(
                    array('method' => 'email', 'minutes' => 24 * 60),
                    array('method' => 'popup', 'minutes' => 10),
                ),
            ),
        ));

        $calendarId = 'primary';
        $event = $service->events->insert($calendarId, $event);
        Log::info(print_r($event,true));
//        Log::info("event");

    }

    private function createTourCalendar($tour_place, $type, $time)
    {

//        $today = Carbon::now()->format('m/d/Y');

//        $users = DB::connection('mysql2')->table('pos_rents_orders')
//            ->where('date', $today)
//            ->where('served',1)
//            ->whereNotNull('customer_email')
//            ->get();

//        Log::info("user: ".count($users));
//        Log::info("path: ".storage_path());
        $tours = DB::connection('mysql2')->table('pos_tours_orders')->where('tour_place',$tour_place)->where($type,'>',0)->where('time',$time)->where('onCalendar',0)->whereNotNull('web_source')->get();
//        $tour = DB::connection('mysql2')->table('pos_tours_orders')->where($type,'>',0)->where('onCalendar',0)->whereNotNull('web_source')->first();
//        dd($tours);
//        dd(app()->bound("TourCalendar"));
        if(count($tours)>0) {
            $tc = new TourCalendar;
//            dd("here");
            $cnt = 0;
            foreach ($tours as $tour) {


                $tc->total_people += $tour->total_people;
//            dd($tc);
                if ($cnt == 0) {
                    $tc->tour_place = $tour->tour_place;
                    $tc->tour_type = $tour->tour_type;

                    $tc->start_dateTime = $this->dateTimeGenerate($tour->date, $tour->time, "start");
                    $tc->end_dateTime = $this->dateTimeGenerate($tour->date, $tour->time, "end");
                }
                $cnt++;
//            dd($end_dateTime);
                $tc->description .= $tour->customer_name . ' ' . $tour->customer_lastname . ', '
                    . $tour->customer_email . ', '
                    . $tour->customer_address_phone . ',' . '<br />'
                    . " " . $tour->total_people . " person(s)" . '<br />';

                $tour_type = $this->getTourType($tour);

                $this->updateDBAfter($tour);
            }
//        dd($tc);
            $tc->description .= "total: " . $tc->total_people . '<br />';

            $this->createEvent($tc,$type);
        }


    }

    private function updateDBAfter($tour){
        DB::connection('mysql2')->table('pos_tours_orders')->where('id',$tour->id)->update(['onCalendar' => 1]);;

//        dd($tour);

    }

}
