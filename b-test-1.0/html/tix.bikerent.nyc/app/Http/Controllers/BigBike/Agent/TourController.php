<?php

namespace App\Http\Controllers\BigBike\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;
use Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use \Milon\Barcode\DNS1D;
use App\User;
use App\PosToursOrder;
use App\TourCalendar;
use App\AgentPercentageList;
//use App\Mail\Rentorder;
use App\Jobs\VoucherTourJob;
use Log;
use DateTime;
class TourController extends Controller implements AgentInterface
{
    public function loginAgent()
    {

        $agent_rent_table = DB::table('agent_rents')->get();
        $agent_tour_table = DB::table('agent_tours')->get();
        return view('bigbike.agent.main', ['agent_rent_table' => $agent_rent_table, 'agent_tour_table' => $agent_tour_table]);

    }


    public function getOrder()
    {

//        return view('bigbike.agent.tour-order');
//        Mail::to('xdrealmadrid@gmail.com')->send(new Rentorder());

//        curl --request POST \
//        --data '{"personalizations": [{"to": [{"email": "recipient@example.com"}]}],"from": {"email": "sendeexampexample@example.com"},"subject": "Hello, World!","content": [{"type": "text/plain", "value": "Heya!"}]}'
//        --data '{"personalizations": [{"to": [{"email": "recipient@example.com"}]}],"from": {"email": "sendeexampexample@example.com"},"subject":"Hello, World!","content": [{"type": "text/plain","value": "Heya!"}], "template_id" : "YOUR_TEMPLATE_ID"}'

//        $data = array(
//            "personalizations"=>array(array(
//                "to"=>array(array(
//                    "email" => "xdrealmadrid@gmail.com"
//                )),
//                "substitutions"=>array(
//                    "%fname%"=> "recipient",
//                    "%CustomerID%"=> "CUSTOMER ID GOES HERE"
//                ),
//            )),
//            "from" =>  array("email" => "voucher@bikerent.nyc"),
//            "subject" => "Hello, World!",
//
////            "to" => array ("email" => "xdrealmadrid@gmail.com"),
//            "content" => array([
//                "type" => "text/plain",
//                "value"=>"Heya!"]),
//            "template_id"=>"28d5da8b-1294-426c-8b7b-c408c07610e5");
//
//        $header_key =  "authorization: Bearer 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";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//            'Content-Type: application/json',
//            $header_key
//        ));
////        curl_setopt($ch, CURLOPT_URL,"https://api.sandbox.paypal.com/v1/oauth2/token");
//        curl_setopt($ch, CURLOPT_URL,"https://api.sendgrid.com/v3/mail/send");
//
//        curl_setopt($ch, CURLOPT_POST, 1);
////        curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$secret");
////        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
////        $data =
//        $data = json_encode(  $data );
////        dd($data);
//        curl_setopt( $ch, CURLOPT_POSTFIELDS, $data );
//
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//        $server_output = curl_exec ($ch);
//        curl_close ($ch);
//        dd($server_output);
//        $data = json_decode($server_output);


        if (Auth::user()->modelHasRole->role_id == 4) {
            $table = "agent_tours";
        } elseif (Auth::user()->modelHasRole->role_id == 3 || Auth::user()->modelHasRole->role_id == 6) {
            $table = "agent_tours_10_off";
        }


        $agent_tour_table = DB::table($table)->get();

        $percentage_rate = AgentPercentageList::where("user_id", Auth::user()->id)->first();
//        dd($percentage_rate);
//        dd($percentage_rate->percentages);
        $rate = $percentage_rate->percentages->percentage_rate / 100.00;

        return view('bigbike.agent.tour-main', ['agent_tour_table' => $agent_tour_table, 'rate' => $rate]);

    }

    public function calculate(Request $request)
    {

//        $tax = 1;
        $tax = 1.08875;

        if (Auth::user()->modelHasRole->role_id == 4) {
            $table = "agent_tours";
        } elseif (Auth::user()->modelHasRole->role_id == 3 || Auth::user()->modelHasRole->role_id == 6) {
            $table = "agent_tours_10_off";
        }

        $percentage_rate = AgentPercentageList::where("user_id", Auth::user()->id)->first();
//        dd($percentage_rate);
//        dd($percentage_rate->percentages);
        $rate = $percentage_rate->percentages->percentage_rate / 100.00;


        $agenttours = DB::table($table)->where('title', $_POST['tour_type'])->first();
        $adult_tour = intval($_POST['adult_tour']);
        $child_tour = intval($_POST['child_tour']);
        $total_price = 0;
        $total_price += $agenttours->adult * $adult_tour;
        $total_price += $agenttours->child * $child_tour;
        session(['total_tour_price_before_tax' => $total_price]);
        $total_price = number_format($rate * $total_price * $tax, 2);

        session(['total_price_after_tax' => $total_price, "original_price" => $total_price]);

        return ['total_tour_price_after_tax' => $total_price, 'total_people' => ($adult_tour + $child_tour)];
    }


    public function submitForm(Request $request)
    {

        $this->calculate($request);

        if ($request->has('credit_card')) {

//            $payment_type = $request->credit_card;
            $payment_type = "Credit Card";

            $order_completed = 0;
            //$tour_agent_total_pay = session('total_tour_price_after_tax');
            $tour_agent_total_pay = session('total_price_after_tax');

            if ($request->tour_total > session('total_price_after_tax')) {
                //price too low, can not complete the transaction
                session(['tour_price_error' => 'price is too high']);
                return redirect()->route('agent.tourOrder');
            }
            $cash_deposit_checked = 0;

        } else {
            $percentage_rate = AgentPercentageList::where("user_id", Auth::user()->id)->first();
//        dd($percentage_rate);
//        dd($percentage_rate->percentages);
            $rate = $percentage_rate->percentages->percentage_rate / 100.00;

//            $payment_type = $request->cash;
            $payment_type = "Cash";
            if (isset($request->comCheckbox)) {
                $cash_deposit_checked = 1;
            } else {
                $cash_deposit_checked = 0;
            }
            $order_completed = 1;
            $tour_agent_total_pay = $request->tour_tips;

            if (floatval($request->tour_tips) > floatval(session('total_price_after_tax') * $rate) + 0.01) {
                //price too low, can not complete the transaction
                session(['tour_price_error' => 'agent price is too high to complete this order']);
                return redirect()->route('agent.tourOrder');
            }
        }


        $total_people = 0;
        if ($request->has('child_tour')) {
            $total_people += $request->child_tour;
        }
        if ($request->has('adult_tour')) {
            $total_people += $request->adult_tour;
        }

        $agent = DB::table('users')->where('email', Auth::user()->email)->first();
        if ($request->location == "145 Nassau Street") {

            $tour_place = "Brooklyn Bridge";
        } else {
            $tour_place = "Central Park";

        }
        session(["location" => $request->location]);

        $order_id = DB::connection('mysql2')->table('pos_tours_orders')->insertGetId([
            "location" => $request->location, "tour_place" => $tour_place, "cashier_email" => "reservation@bikerent.nyc",
            'customer_name' => $request->tour_customer_first, 'customer_lastname' => $request->tour_customer_last,
            'customer_email' => $request->tour_email,
            'tix_agent' => $agent->first_name . ' ' . $agent->last_name,
            "agent_email" => Auth::user()->email,
            'order_completed' => $order_completed, 'payment_type' => $payment_type,
            'order_id' => "", 'reservation' => 1, 'total_price_before_tax' => session('total_tour_price_before_tax'),
            'total_price_after_tax' => session('total_price_after_tax'), "original_price" => session("original_price"),
            'agent_price_after_tax' => $tour_agent_total_pay, 'created_at' => date("Y-m-d H:i:s"),
            'real_time' => date("Y-m-d H:i:s"), 'tour_type' => $request->tour_type, 'date' => $request->tour_date,
            'time' => $request->tour_time, 'adult' => $request->has('adult_tour') ? $request->adult_tour : 0,
            'child' => $request->child_tour, 'served' => 0,
            'total_people' => $total_people, 'comment' => $request->comment, 'cash_deposit_checked' => $cash_deposit_checked
        ]);

        if ($request->has('cash')) {
            //$barcode = $order_id;
            $ac = new AgentController();
            $barcode = $ac->barcodeEncode(intval($order_id), 'PT');

            try {
                DB::connection('mysql2')->table('pos_tours_orders')
                    ->where('id', $order_id)
                    ->update(['barcode' => $barcode]);
            } catch (\Exception $exception) {
                return redirect()->route('agent.tourOrder')->with('error', $exception->getMessage());
            }

            session(['tour_id' => $order_id]);
//            return redirect()->route('agent.tourOrder');
//            $agent_tours_order = DB::table('agent_tours_orders')->where('id', $order_id)->get();
//            $agent_tours_order = json_decode(json_encode($agent_tours_order), true);

            return redirect()->route('agent.tourReceipt');

//            return view('bigbike.agent.tour-receipt',['agent_tours_order'=>$agent_tours_order[0], 'tour_success'=>'Order Completed!']);
        }

        session(['tour_id' => $order_id, 'agent_tour_price_after_tax' => session('total_price_after_tax'), 'tour' => 'tour', 'rent' => null]);
        return view('bigbike.agent.cc-checkout', ['price' => session('agent_tour_price_after_tax'), 'firstname' => $request->tour_customer_first, 'lastname' => $request->tour_customer_last]);


    }

    public function postCCCheckout(Request $request)
    {
        if (!Session::has('agent_tour_price_after_tax')) {
            return redirect()->route('agent.rentOrder');
        }

        Stripe::setApiKey('sk_test_9P20f4nfmi3L4tAqGZkZgf30');
        // Token is created using Stripe.js or Checkout!
        // Get the payment token submitted by the form:
        $token = $_POST['stripeToken'];

        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => Session::get('agent_tour_price_after_tax') * 100,
                "currency" => "usd",
                "description" => "Example charge",
                "source" => $token,
            ));

            //update db
            $tour_id = Session::get('tour_id');
//            $barcode = $tour_id;

            $ac = new AgentController();
            $barcode = $ac->barcodeEncode(intval($tour_id));
            DB::connection('mysql2')->table('agent_tours_orders')
                ->where('id', $tour_id)
                ->update(['order_completed' => 1, 'order_id' => $charge->id, 'customer_name' => $request->cardholder_name, 'completed_at' => date("Y-m-d H:i:s"), 'barcode' => $barcode]);

        } catch (\Exception $exception) {
            return redirect()->route('agent.tourOrder')->with('error', $exception->getMessage());
        }
        //session(['tour_id' => null]);

        Session::forget('cart');

        //return view('bigbike.agent.agent-tour-receipt',['agent_tours_order'=>$agent_tours_order, 'tour_success'=>'Order Completed!', 'barcode'=>$barcode]);
        return redirect()->route('agent.tourReceipt');

    }


    public function postppCheckout(Request $request)
    {
        if (!Session::has('agent_tour_price_after_tax')) {
            return redirect()->route('agent.404');
        }
        $ac = new AgentController();

        $data = $ac->makePPPmt($request);
//        dd($data);
        $unique_id = $data->transactions[0]->related_resources[0]->sale->id;


        if (array_key_exists('message', $data)) {
//            CREDIT_CARD_CVV_CHECK_FAILED
            if ($data->{'message'} == 'Credit card was refused.') {
                session(['error' => 'Credit card was refused.']);
            } else if ($data->{'message'} == 'Credit card CVV check failed.') {
                session(['error' => 'Credit card CVV check failed.']);
            }

            return redirect()->route('agent.tourOrder');
        }

        if ($data->{'state'} == 'approved') {
            //update db
            $tour_id = Session::get('tour_id');
            $barcode = $ac->barcodeEncode(intval($tour_id), 'PT');

            try {
                DB::connection('mysql2')->table('pos_tours_orders')
                    ->where('id', $tour_id)
                    ->update(['order_completed' => 1, 'customer_cc_name' => $request->cc_firstname, 'customer_cc_lastname' => $request->cc_lastname, 'order_id' => $unique_id, 'completed_at' => date("Y-m-d H:i:s"), 'barcode' => $barcode]);

            } catch (\Exception $exception) {
                return redirect()->route('agent.tourOrder')->with('error', $exception->getMessage());
            }
        } else {
            return redirect()->route('agent.tourOrder')->with('error', "credit card was declined");
        }

        Session::forget('agent_tour_price_after_tax');
        //return view('bigbike.agent.agent-rent-receipt',['agent_rents_order'=>$agent_rents_order[0],'rent_success'=>'Order Completed!','barcode'=>Session::pull('order_id')]);
        return redirect()->route('agent.tourReceipt');
    }


    public function printReceipt()
    {

        if (Session::has('tour_id')) {
            Log::info("here");
            $agent_tours_order = PosToursOrder::where('id', Session::get('tour_id'))->first();

            $dns = new DNS1D();
            $data = "data:image/png;base64," . $dns->getBarcodePNG($agent_tours_order->barcode, "C39");


            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path() . '/images/barcode/tour/' . $agent_tours_order->barcode . '.png', $data);
//            file_put_contents('https://52.54.211.223'.'/images/barcode/tour/'.$agent_tours_order->barcode.'.png', $data);

            $hide = false;
            if (!empty($agent_tours_order->customer_email)) {

//                $this->sendOrderEmail($agent_tours_order->customer_email, $agent_tours_order);
//                Mail::to('xdrealmadrid@gmail.com')->send(new Rentorder($agent_tours_order));
                if (Auth::user()->modelHasRole->role_id == 4) {
                    $hide = true;
                    $job1 = (new VoucherTourJob(Auth::user()->email, $agent_tours_order->customer_email, $agent_tours_order, $hide, false))->onConnection('database');
//            dispatch($job);
                    dispatch($job1);
                }

            }
            Log::info("here2");
            $job = (new VoucherTourJob(Auth::user()->email, Auth::user()->email, $agent_tours_order, $hide, true))->onConnection('database');
//            dispatch($job);
            dispatch($job);

//            $this->sendOrderEmail(Auth::user()->email, $agent_tours_order,true);

//            $this->sendOrderEmail(Auth::user()->email,$agent_tours_order);

            $agent_tours_order = json_decode(json_encode($agent_tours_order), true);
            session(['tour_success' => 'Order completed!']);

            return view('bigbike.agent.tour-receipt', ['agent_tours_order' => $agent_tours_order]);
        } else {
            return redirect()->route('agent.main');
        }
    }

    public function sendOrderEmail($email, $agent_tours_order, $type = false)
    {

//        $user = User::where("email",$agent_tours_order->tix_agent)->first();
        $location = DB::table("locations")->where("title", $agent_tours_order->location)->first();
//        $purchase_date = $agent_rents_order->created_at;
        explode(" ", $agent_tours_order->created_at)[0];
        $date = date_create(explode(" ", $agent_tours_order->created_at)[0]);
        $date = $date->format('Y-m-d');

        $new_date = date('F dS Y', strtotime($date));

        $data = array(
            'name' => 'Bigbike',
            'msg' => 'Order Confirmation',
            'payment_type' => $agent_tours_order->payment_type,
            'completed_at' => $new_date,
            'agent' => $agent_tours_order->tix_agent,
//            'agent_email'=>$agent_tours_order->tix_agent,
            'location' => $agent_tours_order->location . " New York, NY " . $location->zipcode,
            'tour_type' => mb_strtoupper($agent_tours_order->tour_type),
            'tour_place' => strtoupper($agent_tours_order->tour_place),
            'customer_name' => $agent_tours_order->customer_name . " " . $agent_tours_order->customer_lastname,
            'total_price_after_tax' => $agent_tours_order->total_price_after_tax,
            'agent_price_after_tax' => $agent_tours_order->agent_price_after_tax,
            'barcode' => $agent_tours_order->barcode,
            'customer_email' => $agent_tours_order->customer_email,
            'date' => $agent_tours_order->date,
            'time' => $agent_tours_order->time, 'tour_type' => $agent_tours_order->tour_type,
            'adult' => $agent_tours_order->adult,
            'child' => $agent_tours_order->child,
            'hide_price' => $type,
            "barcode" => $agent_tours_order->barcode . '.png',
            'agent_phone' => Auth::user()->phone,
            'phone' => $location->phone,
            'total_people' => $agent_tours_order->total_people
        );

//        Mail::send('emails.order-customer-email', $data, function ($message) use($email,$pdf) {
        //if($type=='agent')
        Mail::send('emails.tour-email', $data, function ($message) use ($email) {
            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');
//            $pdf = PDF::loadView('emails.signup-welcome', 'A4', 'portrait');
//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');

            $message->to($email)->subject('Order Confirmation');

//            $message->attach($pdf->output(),['filename.pdf']);
            //$message->attachData($data, ['invoice.pdf']);

        });
    }

    public function sendCustomerEmail($email)
    {
        $data = array('name' => 'Bigbike', 'msg' => 'Order Confirmation');
        Mail::send('emails.order-customer-email', $data, function ($message) use ($email) {

            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');

//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
            $message->to($email)->subject('Order Confirmation');

        });
    }

    public function sendAgentEmail($email)
    {
        $data = array('name' => 'Bigbike', 'msg' => 'Order Confirmation');
        Mail::send('emails.order-agent-email', $data, function ($message) use ($email) {

            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');

//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
            $message->to($email)->subject('Order Confirmation!');

        });
    }

    public function printTicket()
    {
        if (Session::has('tour_id')) {

            $agent_tours_order = DB::connection('mysql2')->table('pos_tours_orders')->where('id', Session::get('tour_id'))->get();
            $agent_tours_order = json_decode(json_encode($agent_tours_order), true);
            session(['tour_success' => 'Order completed!']);
            return view('bigbike.agent.tour-ticket', ['agent_tours_order' => $agent_tours_order[0], 'tour_success' => 'Order Completed!']);
        } else {
            return redirect()->route('agent.main');
        }
    }

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

//                $this->updateDBAfter($tour);
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

    private function updateTourCalendar(){

    }

}
