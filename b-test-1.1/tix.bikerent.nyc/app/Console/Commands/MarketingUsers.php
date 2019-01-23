<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Mail\SendMarketingEmail;
use Carbon\Carbon;
use Log;
use Mail;

class MarketingUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marketing:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send marketing email to customer';

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
    public function handle()
    {
//        Log::info("handle");
        $today = Carbon::now()->format('m/d/Y');
        $users = DB::connection('mysql2')->table('pos_rents_orders')
            ->where('date', $today)
            ->where('served',1)
            ->whereNotNull('customer_email')
            ->get();

        Log::info("user: ".count($users));
//        $cnt = 0;
        foreach ($users as $user) {
            $yelp_url = "https://yelp.com/";
            $google_url = "https://google.com/";
            $trip_url = "https://tripadvisor.com/";
            Log::info("success: ".$user->customer_name." ".$user->customer_lastname);
            if($user->location=="145 Nassau Street"){
                $yelp_url .= "";
                $google_url .= "maps/place/Brooklyn+Bridge+Bike+Rent/@40.7082116,-74.0097602,15z/data=!4m8!1m2!2m1!1sbrooklyn+bridge+bike+rental!3m4!1s0x89c25a227fcd1c5d:0xc0e8362b68069bdf!8m2!3d40.7115093!4d-74.0062631";
                $trip_url .= "Attraction_Review-g60763-d7935951-Reviews-Brooklyn_Bridge_Bike_Rent-New_York_City_New_York.html";
            }elseif($user->location=="203W 58th Street"){
                $yelp_url .= "";
                $google_url .= "maps/place/Central+Park+Bike+Tours/@40.7664578,-73.9799075,15z/data=!4m2!3m1!1s0x0:0xd592799ba8de1f26?sa=X&ved=2ahUKEwiWrqvxkf_dAhWHmeAKHa9XCV4Q_BIwEHoECAwQCw";
                $trip_url .= "Attraction_Review-g60763-d1198657-Reviews-Central_Park_Bike_Tours-New_York_City_New_York.html";
            }elseif($user->location=="40W 55th Street" || $user->location=="452 West 45th Street"){
                $yelp_url .= "";
                $google_url .= "maps/place/Rental+Bike/@40.7664578,-73.9799075,15z/data=!4m12!1m6!3m5!1s0x0:0xd592799ba8de1f26!2sCentral+Park+Bike+Tours!8m2!3d40.7664578!4d-73.9799075!3m4!1s0x0:0xecf64dcceeb376fe!8m2!3d40.7623146!4d-73.9768106";
                $trip_url .= "Attraction_Review-g60763-d4936855-Reviews-Rental_Bike_NYC-New_York_City_New_York.html";
            }elseif($user->location=="117W 58th Street"){
                $yelp_url .= "";
                $google_url .= "maps/place/Central+Park+Bike+Rentals/@40.7664578,-73.9799075,15z/data=!4m12!1m6!3m5!1s0x0:0xd592799ba8de1f26!2sCentral+Park+Bike+Tours!8m2!3d40.7664578!4d-73.9799075!3m4!1s0x0:0xdd9955bd2eca96b5!8m2!3d40.7654615!4d-73.9772666";
                $trip_url .= "Attraction_Review-g60763-d2060551-Reviews-Central_Park_Bike_Ride-New_York_City_New_York.html";
            }elseif (($user->location == 'Central Park South') ||
                ($user->location == 'Central Park West') ||
                ($user->location == 'Grand Army Plaza')) {
                $yelp_url .= "";
                $google_url .= "maps/place/Central+Park+West+Bike+Rental/@40.7688123,-73.981837,19z/data=!4m12!1m6!3m5!1s0x0:0xd592799ba8de1f26!2sCentral+Park+Bike+Tours!8m2!3d40.7664578!4d-73.9799075!3m4!1s0x89c258f66bb82bf9:0x5887a3aa3f7c7937!8m2!3d40.7688123!4d-73.9812899";
                $trip_url .= "Attraction_Review-g60763-d14920754-Reviews-Central_Park_Bike_Rental-New_York_City_New_York.html";
            }

            Mail::to($user->customer_email)->send(new SendMarketingEmail($user->customer_name." ".$user->customer_lastname,$yelp_url,$google_url,$trip_url));
//            Mail::to($user->customer_email)->send(new SendMarketingEmail($user->customer_name." ".$user->customer_lastname));
//            $cnt++;
//            if($cnt==30){
//                break;
//            }
        }

    }
}
