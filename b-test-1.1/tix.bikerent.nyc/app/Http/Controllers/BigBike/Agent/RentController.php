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
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentCard;
use PayPal\Api\Transaction;
use PayPal\Api\CreditCard;
use Paypal\Exception;
use App\Jobs\VoucherRentJob;
use App\PosRentsOrder;
use App\AgentPercentageList;
use Log;
use PDF;




class RentController extends Controller implements AgentInterface
{
    public function getOrder(){

        return view('bigbike.agent.rent-order');
    }

    public function getRent(){
        if(Auth::user()->modelHasRole->role_id==4){
            $table = "agent_rents";
        }elseif(Auth::user()->modelHasRole->role_id==3 || Auth::user()->modelHasRole->role_id==6){
            $table = "agent_rents_10_off";
        }

//        $this->pdf();

//        agent_rents_30_after_10

        $agent_rent_table= DB::table($table)->get();
        $percentage_rate = AgentPercentageList::where("user_id",Auth::user()->id)->first();
//        dd($percentage_rate);
//        dd($percentage_rate->percentages);
        $rate = $percentage_rate->percentages->percentage_rate/100.00;

        return view('bigbike.agent.rent-main',['agent_rent_table'=>$agent_rent_table,'rate'=>$rate]);

    }


    public function calculate(Request $request){
        $rent_duration = $_POST['rent_duration'];
//        $tax = 1;
        $tax = 1.08875;

        if($_POST['rent_duration']=="All Day (8am-8pm)"){
            $rent_duration = 'all day';
        }
        $table = "agent_rents";

//        if(Auth::user()->modelHasRole->role_id==4){
//            $table = "agent_rents";
//        }elseif(Auth::user()->modelHasRole->role_id==3){
//            $table = "agent_rents_10_off";
//        }

        $agentrents = DB::table($table)->where('title', $rent_duration)->first();
        $adult_bike = intval($_POST['adult_bike']);
        $child_bike = intval($_POST['child_bike']);
        if($rent_duration != '24 hours') {
            $tandem_bike = intval($_POST['tandem_bike']);
            $road_bike = intval($_POST['road_bike']);
            $mountain_bike = intval($_POST['mountain_bike']);
            $trailer = intval($_POST['trailer_bike']);
            $seat = intval($_POST['seat_bike']);
            $basket = intval($_POST['basket_bike']);
        }else{
            $tandem_bike = 0;
            $road_bike = 0;
            $mountain_bike = 0;
            $trailer = 0;
            $seat = 0;
            $basket = 0;
        }
        $total_price = 0;

        $original_price = 0;
        $total_bikes = $adult_bike+$child_bike+$tandem_bike+$road_bike+$mountain_bike;
        $total_doubleBikes = $tandem_bike+$road_bike+$mountain_bike;
        if(Auth::user()->modelHasRole->role_id==3) {

            $total_price += number_format(0.7 * 0.9*$agentrents->adult * $adult_bike, 2);
            $total_price += number_format(0.7 * 0.9*$agentrents->child * $child_bike, 2);

        }elseif(Auth::user()->modelHasRole->role_id==6){
            $total_price += number_format(0.65 * 0.9*$agentrents->adult * $adult_bike, 2);
            $total_price += number_format(0.65 * 0.9*$agentrents->child * $child_bike, 2);
        }else{
            $total_price += number_format(0.7 * $agentrents->adult * $adult_bike, 2);
            $total_price += number_format(0.7 * $agentrents->child * $child_bike, 2);
        }

        $original_price += $agentrents->child * $child_bike;
        $original_price += $agentrents->adult * $adult_bike;

        if(Auth::user()->modelHasRole->role_id==4){
            $total_price += number_format(0.7*$agentrents->tandem*$tandem_bike,2);
            $total_price += number_format(0.7*$agentrents->road*$road_bike,2);
            $total_price += number_format(0.7*$agentrents->mountain*$mountain_bike,2);
        }
        else{
            $total_price += number_format($agentrents->tandem*$tandem_bike,2);
            $total_price += number_format($agentrents->road*$road_bike,2);
            $total_price += number_format($agentrents->mountain*$mountain_bike,2);
        }
        $original_price += $agentrents->tandem*$tandem_bike;
        $original_price += $agentrents->road*$road_bike;
        $original_price += $agentrents->mountain*$mountain_bike;


        $total_price += $agentrents->trailer*$trailer;
        $total_price += $agentrents->seat*$seat;
        $total_price += $agentrents->basket*$basket;

        $original_price += $agentrents->trailer*$trailer;
        $original_price += $agentrents->seat*$seat;
        $original_price += $agentrents->basket*$basket;

        if(isset($_POST['insurance'])){
            $total_price+= $agentrents->insurance*($total_bikes-$total_doubleBikes);
            $total_price+= 2*$agentrents->insurance*($total_doubleBikes);

            $original_price += $agentrents->insurance*($total_bikes-$total_doubleBikes);
            $original_price += 2*$agentrents->insurance*($total_doubleBikes);
        }
        if(isset($_POST['dropoff'])){
            $total_price+= $agentrents->dropoff*($total_bikes+$total_doubleBikes);

            $original_price += $agentrents->dropoff*($total_bikes+$total_doubleBikes);

        }
        $total_price = $total_price;
        $total_price_after_tax = number_format($total_price*$tax,2);
        //echo $request;
//        if(Auth::user()->modelHasRole->role_id==4){
//            session(["original_price"=>$total_price]);
//        }elseif(Auth::user()->modelHasRole->role_id==3){
//            session(["original_price"=>number_format($total_price/0.7,2)]);
//        }


        session(["original_price"=>$original_price,'total_price_before_tax'=>$total_price,'total_price_after_tax' => $total_price_after_tax,'total_bikes'=>$total_bikes]);
//        dd(Session::get('total_price_before_tax'));
        return ['total_price_after_tax' => session('total_price_after_tax')];
    }

    public function submitForm(Request $request){

        $this->calculate($request);

        if($request->has('credit_card')){
//            $payment_type = $request->credit_card;
            $payment_type = 'Credit Card';
            $order_completed = 0;
            $cash_deposit_checked = 0;
            //$rent_agent_total_pay = session('total_price_after_tax');
            $rent_agent_total_pay= session('total_price_after_tax');
            $served = 0;

            if(floatval($request->rent_total_pay)>floatval(session('total_price_after_tax'))){
                //price too low, can not complete the transaction
                session(['rent_price_error' => 'price is too high']);
                return redirect()->route('agent.rentOrder');
            }
        }else{
//            $payment_type = $request->cash;
            $percentage_rate = AgentPercentageList::where("user_id",Auth::user()->id)->first();
//        dd($percentage_rate);
//        dd($percentage_rate->percentages);
            $rate = $percentage_rate->percentages->percentage_rate/100.00;
//            dd($rate);
            $payment_type = 'Cash';
            if(isset($request->comCheckbox)){
                $cash_deposit_checked = 1;
            }else{
                $cash_deposit_checked = 0;
            }
            $order_completed = 1;
//            dd("here".$request->rent_tips_label);
            $rent_agent_total_pay = $request->rent_tips_label;
            $served = 0;
//            if(floatval($request->rent_tips_label) > floatval(session('total_price_after_tax'))*$rate+0.10){
//                dd($request->rent_tips_label." ".(floatval(session('total_price_after_tax'))*$rate+0.10));
//
//                //price too low, can not complete the transaction
//                session(['rent_price_error' => 'agent price is too high to complete this order']);
////                session(['rent_price_error' => floatval($request->rent_tips_label)]);
//
//                return redirect()->route('agent.rentOrder');
//            }
        }

        if($request->rent_duration=='All Day (8am-8pm)'){
            $endTime = date('Y-m-d H:i:s', strtotime('today 8pm'));
        }else{
            $endTime = date('Y-m-d H:i:s', strtotime($request->rent_duration));
        }

        $agent = DB::table('users')->where('email', Auth::user()->email)->first();
        $ac = new AgentController();
        $array = $ac->getLocationTable($request->location);
        $num = $array[0];
        $table = $array[1];

        $futureDate=date('Y-m-d', strtotime('+1 year', strtotime($request->rent_date)));

        session(["location"=>$request->location]);
        $rent_id = DB::connection('mysql2')->table('pos_rents_orders')->insertGetId([
            "location"=>$request->location,"cashier_email"=>"reservation@bikerent.nyc",'customer_name' => $request->rent_customer,
            'customer_lastname' => $request->rent_customer_last,'customer_email' => $request->rent_email,
            'tix_agent' => $agent->first_name.' '.$agent->last_name, 'order_completed' => $order_completed,
            'payment_type' => $payment_type,'reservation'=>1,'order_id' => "","original_price"=>session('original_price'),
            'total_price_before_tax'=>session('total_price_before_tax'),'total_price_after_tax' => session('total_price_after_tax'),'agent_email'=>Auth::user()->email,
            'agent_price_after_tax' => $rent_agent_total_pay,'created_at'=>date("Y-m-d H:i:s"),'date' => $futureDate, 'time' => date("Y-m-d H:i:s"), 'adult' => $request->adult_bike
            , 'child' => $request->child_bike, 'tandem' => $request->tandem_bike, 'road' => $request->road_bike, 'mountain' => $request->mountain_bike, 'trailer' => $request->trailer_bike,'total_bikes'=>session('total_bikes'),
            'basket' => $request->basket_bike, 'seat' => $request->seat_bike, 'dropoff' => $request->dropoff=='on'?1:0, 'insurance' => $request->insurance=='on'?1:0,'end_time'=>$endTime
            , 'duration' => $request->rent_duration,'served'=>$served, 'comment' => $request->comment,'cash_deposit_checked'=>$cash_deposit_checked,'sequantial'=>strtoupper($table).$num]);


        if($request->has('cash')){
            $ac = new AgentController();
            $barcode = $ac->barcodeEncode(intval($rent_id),'PR');

            try{

                DB::connection('mysql2')->table('pos_rents_orders')
                    ->where('id', $rent_id)
                    ->update(['barcode'=>$barcode]);

            }catch(\Exception $exception){

                return redirect()->route('agent.rentOrder')->with('error', $exception->getMessage());

            }


            session(['rent_id'=>$rent_id]);
            //return redirect()->route('agent.main');
            //$agent_rents_order = DB::table('agent_rents_orders')->where('id', $order_id)->get();
            //session(['success'=>'transaction completed!']);
            //$agent_rents_order = json_decode(json_encode($agent_rents_order), true);



            return redirect()->route('agent.rentReceipt');
            //return view('bigbike.agent.agent-receipt',['agent_rents_order'=>$agent_rents_order[0],'rent_success'=>'Order Completed!']);
        }

        session(['rent_id' => $rent_id, 'agent_price_after_tax' => session('total_price_after_tax'), 'rent'=>'rent','tour'=>null]);
        //$this->paypalTest();
        return view('bigbike.agent.cc-checkout',['price'=>session('total_price_after_tax'),'firstname'=>$request->rent_customer,'lastname'=>$request->rent_customer_last]);
    }

    public function postCCCheckout(Request $request){
        if(!Session::has('agent_price_after_tax')){
            return redirect()->route('agent.rentOrder');
        }

        Stripe::setApiKey('sk_test_9P20f4nfmi3L4tAqGZkZgf30');
        // Token is created using Stripe.js or Checkout!
        // Get the payment token submitted by the form:
        $token = $_POST['stripeToken'];

        try{
            $charge = \Stripe\Charge::create(array(
                "amount" =>  Session::get('agent_price_after_tax')*100,
                "currency" => "usd",
                "description" => "Example charge",
                "source" => $token,
            ));
            //update db
            $rent_id = Session::get('rent_id');
            $ac = new AgentController();
            $barcode = $ac->barcodeEncode(intval($rent_id));

            DB::connection('mysql2')->table('agent_rents_orders')
                ->where('id', $rent_id)
                ->update(['order_completed' => 1, 'order_id'=>$charge->id,'customer_name'=>$request->cardholder_name,'completed_at'=> date("Y-m-d H:i:s"),'barcode'=>$barcode]);

        }catch(\Exception $exception){
            return redirect()->route('agent.rentOrder')->with('rent_price_error', $exception->getMessage());
        }

        //return view('bigbike.agent.agent-rent-receipt',['agent_rents_order'=>$agent_rents_order[0],'rent_success'=>'Order Completed!','barcode'=>Session::pull('order_id')]);
        return redirect()->route('agent.rentReceipt');
    }



    public function postppCheckout(Request $request){
        if(!Session::has('agent_price_after_tax')){
            return redirect()->route('agent.404');
        }
        $ac = new AgentController();
        $data = $ac->makePPPmt($request);
//        dd($unique_id);

//        dd($data->{'error'});
        if(array_key_exists('message', $data) ) {
//            CREDIT_CARD_CVV_CHECK_FAILED
//            if($data->{'message'}=='Credit card was refused.'){
//                session(['error'=>'Credit card was refused.']);
//            }else if($data->{'message'}=='Credit card CVV check failed.'){
//                session(['error'=>'Credit card CVV check failed.']);
//            }
            session(['error'=>$data->{'message'}]);

            return redirect()->route('agent.rentOrder');
        }


        if($data->{'state'}=='approved') {
            //update db
            $rent_id = Session::get('rent_id');
            $barcode = $ac->barcodeEncode(intval($rent_id),'PR');
            $unique_id = $data->transactions[0]->related_resources[0]->sale->id;

            try{
                DB::connection('mysql2')->table('pos_rents_orders')
                    ->where('id', $rent_id)
                    ->update(['order_completed' => 1,'customer_cc_name' => $request->cc_firstname,'customer_cc_lastname' => $request->cc_lastname,'order_id' => $unique_id,
                        'completed_at' => date("Y-m-d H:i:s"), 'barcode' => $barcode,'served'=>0]);

            }catch(\Exception $exception){
                return redirect()->route('agent.rentOrder')->with('rent_price_error', $exception->getMessage());
            }
        }else{
            return redirect()->route('agent.rentOrder')->with('rent_price_error', "credit card was declined");
        }
        
        Session::forget('agent_price_after_tax');
        //return view('bigbike.agent.agent-rent-receipt',['agent_rents_order'=>$agent_rents_order[0],'rent_success'=>'Order Completed!','barcode'=>Session::pull('order_id')]);
        return redirect()->route('agent.rentReceipt');
    }


    public function printReceipt(){
        if(Session::has('rent_id')) {

//            $agent_rents_order = DB::table('pos_rents_orders')->where('id', Session::get('rent_id'))->first();
            $agent_rents_order = PosRentsOrder::where("id",Session::get('rent_id'))->first();
            $dns = new DNS1D();
            $data = "data:image/png;base64,".$dns->getBarcodePNG($agent_rents_order->barcode, "C39");

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            file_put_contents(public_path().'/images/barcode/rent/'.$agent_rents_order->barcode.'.png', $data);

            $hide = false;
            if(!empty($agent_rents_order->customer_email)){
                //$agent_rents_test = json_decode(json_encode($agent_rents_order), true);
                //for customer
//                dd(Auth::user()->modelHasRole->role_id);
                if(Auth::user()->modelHasRole->role_id==4){
                    $hide = true;
                    $job1 = (new VoucherRentJob(Auth::user()->email, $agent_rents_order->customer_email,$agent_rents_order,$hide,false))->onConnection('database');
                    dispatch($job1);
                }

//                $this->sendCustomerEmail($agent_rents_order[0]->customer_email);
            }
//            //for agent
//            $this->sendCustomerEmail2(Auth::user()->email,$agent_rents_order);

//            $this->sendCustomerEmail2(Auth::user()->email,$agent_rents_order);
            $job = (new VoucherRentJob(Auth::user()->email, Auth::user()->email,$agent_rents_order,$hide,true))->onConnection('database');
//            dispatch($job);
            dispatch($job);




            $agent_rents_order = json_decode(json_encode($agent_rents_order), true);
//            $this->sendAgentEmail(Auth::user()->email);

            session(['rent_success'=>'Order completed!']);
            return view('bigbike.agent.rent-receipt', ['agent_rents_order' => $agent_rents_order, 'rent_success' => 'Order Completed!']);
        }else{
            return redirect()->route('agent.main');
        }
    }

    public function pdf()
    {
//        $user = Festivals::where('id',$id)->first();
        Log::info("test");
        $test = array("test"=>"test2","test2"=>"test3");
        $pdf = PDF::loadView('emails.test',$test);
        $path = public_path("images/pdf/test1.pdf");
        $pdf->save($path);
//        return $pdf->download('invoice.pdf');
    }

    public function sendCustomerEmail2($email, $agent_rents_order,$hide=false){

        $location = DB::table("locations")->where("title",$agent_rents_order->location)->first();
//        $purchase_date = $agent_rents_order->created_at;
        explode(" ",$agent_rents_order->created_at)[0];
        $date=date_create(explode(" ",$agent_rents_order->created_at)[0]);
        $date = $date->format('Y-m-d');

        $new_date = date('F dS Y', strtotime($date));
//        dd($new_date);
        $data = array('name' => 'Bigbike', 'msg' => 'Order Confirmation',
            'payment_type'=>$agent_rents_order->payment_type,
            'agent'=>$agent_rents_order->tix_agent,
            'customer_email'=>$agent_rents_order->customer_email,
            'completed_at'=>$agent_rents_order->completed_at,
            'total_price_after_tax'=>$agent_rents_order->total_price_after_tax,
            'agent_price_after_tax'=>$agent_rents_order->agent_price_after_tax,
            'barcode'=>$agent_rents_order->barcode,
            'customer_name'=>$agent_rents_order->customer_name." ".$agent_rents_order->customer_lastname,
            'customer_email'=>$agent_rents_order->customer_email,
            'location'=>$agent_rents_order->location." New York, NY ".$location->zipcode,
            'date'=>$agent_rents_order->date,
            'time'=>$agent_rents_order->time,
            'duration'=>$agent_rents_order->duration,
            'adult'=>$agent_rents_order->adult,
            'child'=>$agent_rents_order->child,
            'tandem'=>$agent_rents_order->tandem,
            'road'=>$agent_rents_order->road,
            'mountain'=>$agent_rents_order->mountain,
            'trailer'=>$agent_rents_order->trailer,
            'seat'=>$agent_rents_order->seat,
            'basket'=>$agent_rents_order->basket,
            'dropoff'=>$agent_rents_order->dropoff,
            'completed_at'=>$new_date,
            'phone'=>$location->phone,
            "barcode"=>$agent_rents_order->barcode.'.png',
            'agent_phone'=>Auth::user()->phone,
            'hide'=>$hide,
            'insurance'=>$agent_rents_order->insurance);

//        Mail::send('emails.order-customer-email', $data, function ($message) use($email,$pdf) {
        //if($type=='agent')

        Mail::send('emails.rent-email', $data, function ($message) use($email) {


            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');
//            $pdf = PDF::loadView('emails.signup-welcome', 'A4', 'portrait');
//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');

            $message->to($email)->subject('Order Confirmation');


//            $message->attach($pdf->output(),['filename.pdf']);
            //$message->attachData($data, ['invoice.pdf']);

        });
    }

    public function sendCustomerEmail($email){

        $data = array('name' => 'Bigbike', 'msg' => 'Order Confirmation');
        Mail::send('emails.order-customer-email', $data, function ($message) use($email) {

            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');

//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
            $message->to($email)->subject('Order Confirmation');
        });
    }


    public function sendAgentEmail($email){
        $data = array('name' => 'Bigbike', 'msg' => 'Order Confirmation');
        Mail::send('emails.order-agent-email', $data, function ($message) use($email) {

            $message->from('vouchers@bikerent.nyc', 'Order Confirmation');

//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
            $message->to($email)->subject('Order Confirmation');
//            $pdf = PDF::loadView('layouts.factuur', array('factuur' => "hkhjk"));
//
//            $message->attach($pdf->output());

        });
    }

    public function printTicket(){
        if(Session::has('rent_id')) {

            $agent_rents_order = DB::connection('mysql2')->table('pos_rents_orders')->where('id', Session::pull('rent_id'))->get();
            $agent_rents_order = json_decode(json_encode($agent_rents_order), true);
            session(['rent_success'=>'Order completed!']);
            return view('bigbike.agent.rent-ticket', ['agent_rents_order' => $agent_rents_order[0], 'rent_success' => 'Order Completed!']);
        }else{
            return redirect()->route('agent.main');
        }
    }


}
