<?php

namespace App\Http\Controllers\BigBike\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use App\User;
use App\AgentPercentageList;
use Stripe\Stripe;
use Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Log;


class PartnerController extends Controller
{

//"a","b","c","d","e","f","g","h",
//"i","j","k","l","m","n","o","p",
//"q","r","s","t","u","v","w","x",
//"y","z",
    private $barcodeMap = array(
        "A","B","C","D","E","F","G","H",
        "I","J","K","L","M","N","O","P",
        "Q","R","S","T","U","V","W","X",
        "Y","Z","0","1","2","3","4","5",
        "6","7","8","9","-","."," ","$",
        "+","%");

    private $barcodeDeMap = array(
        "A"=>0,"B"=>1,"C"=>2,"D"=>3,"E"=>4,"F"=>5,"G"=>6,"H"=>7,
        "I"=>8,"J"=>9,"K"=>10,"L"=>11,"M"=>12,"N"=>13,"O"=>14,"P"=>15,
        "Q"=>16,"R"=>17,"S"=>18,"T"=>19,"U"=>20,"V"=>21,"W"=>22,"X"=>23,
        "Y"=>24,"Z"=>25,"0"=>26,"1"=>27,"2"=>28,"3"=>29,"4"=>30,"5"=>31,
        "6"=>32,"7"=>33,"8"=>34,"9"=>35,"-"=>36,"."=>37," "=>38,"$"=>39,
        "+"=>40,"%"=>41);


    public function loginAgent(){

//        $agent_rent_table= DB::table('agent_rents')->get();
//        $agent_tour_table= DB::table('agent_tours')->get();
//        return view('bigbike.agent.main',['agent_rent_table'=>$agent_rent_table,'agent_tour_table'=>$agent_tour_table]);
        return view('bigbike.agent.main');

    }

    public function go404(){

//        $agent_rent_table= DB::table('agent_rents')->get();
//        $agent_tour_table= DB::table('agent_tours')->get();
//        return view('bigbike.agent.main',['agent_rent_table'=>$agent_rent_table,'agent_tour_table'=>$agent_tour_table]);
        return view('errors.404');

    }

    public function getReportForm(){
        return view('bigbike.agent.report');

    }

    public function showReport(Request $request){

        $start_date = explode('/', $request->start_date);
        $end_date = explode('/', $request->end_date);

//        $tix_agent = User::where('email', Auth::user()->email)->first();
        $percentage_rate = AgentPercentageList::where("user_id",Auth::user()->id)->first();
//        Log::info("rate: ".$percentage_rate->percentages->percentage_rate);
        $rate = $percentage_rate->percentages->percentage_rate/100.00;
//        Log::info("rate: ".$rate);
//        DB::connection()->enableQueryLog();

        $agent_cc_rents = DB::connection('mysql2')->table('pos_rents_orders')
            ->where("agent_email",Auth::user()->email)
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where('payment_type', 'Credit Card')
            ->where('order_completed', '1')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();


//        $queries = DB:p:getQueryLog();
//        dd($queries);

        $agent_cc_tours = DB::connection('mysql2')->table('pos_tours_orders')
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where("agent_name",Auth::user()->email)
            ->where('payment_type', 'Credit Card')
            ->where('order_completed', '1')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();

        $sum = 0;
        foreach ($agent_cc_rents as $agent_cc_rent){
            if($agent_cc_rent->agent_refund==0) {
                $sum += number_format($rate * (float)$agent_cc_rent->total_price_after_tax, 2);
            }
//            $sum += (float)$agent_cc_rent->agent_price_after_tax;

        }

        foreach ($agent_cc_tours as $agent_cc_tour){
            if($agent_cc_rent->agent_refund==0) {
                $sum += number_format($rate * (float)$agent_cc_tour->total_price_after_tax, 2);
            }
        }

        $cash_sum = 0;

        $agent_cash_rents = DB::connection('mysql2')->table('pos_rents_orders')
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where("agent_email",Auth::user()->email)
            ->where('payment_type', 'Cash')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();

        $agent_cash_tours = DB::connection('mysql2')->table('pos_tours_orders')
            ->where("agent_name",Auth::user()->email)
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where('payment_type', 'Cash')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();

        foreach ($agent_cash_rents as $agent_cash_rent){
            if($agent_cash_rent->agent_refund==0) {

                $cash_sum += (float)$agent_cash_rent->agent_price_after_tax;
//            $sum += (float)$agent_cc_rent->agent_price_after_tax;
            }
        }

        foreach ($agent_cash_tours as $agent_cash_tour){
            if($agent_cash_tour->agent_refund==0) {
                $cash_sum += (float)$agent_cash_tour->agent_price_after_tax;
            }
        }
//        dd($agent_cash_rents);
        return view('bigbike.agent.show-report',['agent_cc_rents'=>$agent_cc_rents,'agent_cc_tours'=>$agent_cc_tours,
            'agent_cash_rents'=>$agent_cash_rents,'agent_cash_tours'=>$agent_cash_tours,'sum'=>$sum,'cash_sum'=>$cash_sum,
            'start_date'=>$start_date[0].'/'.$start_date[1],'end_date'=>$end_date[0].'/'.$end_date[1]]);
//        return view('bigbike.agent.show-report');

    }

    public function barcodeEncode($id,$type){

        $encoded = "";
        $base = sizeof($this->barcodeMap);
        while($id>0){
            $encoded .= $this->barcodeMap[$id%$base];
            $id = intval($id/$base);
        }
        return $type.$encoded;
    }


    public function barcodeDecode($str){
        $id = 0;
        $tmpArr = str_split($str);
        $base = 1;
        $realBase = sizeof($this->barcodeMap);
        foreach ($tmpArr as $c){
            $id += intval($this->barcodeDeMap[$c])*$base;
            $base *= $realBase;
        }
        return $id;
        //return $base;
    }

    public function getResetPage(){
        return view('bigbike.agent.get-email');
    }

    public function getEmail(Request $request){
        try{
            $user = User::where('email', $request->email)->first();

            $this->sendEmail($user);

            session(['msg'=>"Check your email to reset password"]);
            return redirect()->route('user.signin');
        }catch(\Exception $exception){
            return redirect()->route('agent.getResetPage')->with('errors', $exception->getMessage());
        }
    }

    public function sendEmail($user){
        $data = array('name' => 'Bigbike', 'msg' => 'Reset Password', 'remember_token' => $user->remember_token);
        Mail::send('emails.reset-pwd-welcome', $data, function ($message) use($user) {

            $message->from('vouchers@bikerent.nyc', 'Reset Password');

            $message->to($user->email)->subject('Reset Password');

        });
    }

    public function sendEmailAfterResetPwd($user){
        $data = array('name' => 'Bigbike', 'msg' => 'Reset Password Succeed', 'remember_token' => $user->remember_token);
        Mail::send('emails.reset-pwd-succeed', $data, function ($message) use($user) {

            $message->from('vouchers@bikerent.nyc', 'Reset Password Succeed');

            $message->to($user->email)->subject('Reset Password Succeed');

        });
    }

    public function showResetPasswordPage(Request $request){
//        try{
//
//        }catch(\Exception $exception){
//            return redirect()->route('agent.getResetPage')->with('errors', "Please input your email again");
//        }

        return view('bigbike.agent.reset-password',['remember_token'=>$request->remember_token]);
    }

    public function resetPassword(Request $request){

        if ($request->password == $request->password2) {
            try {
                $user = User::where('email', $request->email)->first();
                if($user->remember_token!=$request->remember_token){
                    return redirect()->route('agent.getResetPage')->with('errors', "You already reset your password");
                }else {

                    DB::table('vouchers')
                        ->where('remember_token', $request->remember_token)
                        ->where('email', $request->email)
                        ->update(['password' => bcrypt($request->password)]);
                }
            }catch(\Illuminate\Database\QueryException $exception){
                return redirect()->route('agent.getResetPage')->with('errors', $exception->getMessage());
            } catch(\Exception $exception){
                return redirect()->route('agent.getResetPage')->with('errors', $exception->getMessage());
            }
        }else{
            return redirect()->route('agent.getResetPage')->with('errors', "Please input the same password");
        }
//        $user = DB::table('users')->where('email', $request->email)->first();
        $this->sendEmailAfterResetPwd($user);
        session(['msg'=>"Your password has been updated"]);

        return redirect()->route('user.signin');

    }

    public function contact(){
        return view('bigbike.agent.contact');
    }

    public function getPPToken($location){

//        $client_id = 'Af3pLPpK3yNnXZCUol1mCfp095bIHa3CDlKHqBdZ09DATho5qlzX4Mp7yp2SOuNlMRxj7mNXEam_lx7S';
//        $secret = 'ELypMURkd8RzVy1tw9JIzT_O39cHw3E7hloaYt-zzWNd4C2ymisA5uMZYtNX6XzKRwvsD5XDa1CpzEc2';
        if($location=="203W 58th Street"){

            $client_id = 'AZ2aVD0CQx_FGGPgShZTVQDw4aBCal5Pghva6WMZpYZ5J0Kd5lODfYsWK5MtfMzInhfmFrklusDcymoo';
            $secret = 'EGvqUNiRlZ42JEP-aY9fNlC9VN5-qlJSvZXUAkinLtYXyTSNa2ivqBSN2f9WwcjpDsgws4jvL_LZj5Ft';

        }elseif ($location=="117W 58th Street" || $location=="145 Nassau Street" || $location=="40W 55th Street"){
            $client_id = 'AfnFoI1-bZU-4niJYOjwVEIDEBQHsPayvi_fF6U_kfuMSH0afJNTy79wrvjD5x58nbF6wrOiM6j5bhhc';
            $secret = 'ECL6fi7TzHeKrQeBBUjgaHVu7yMgsBxoztC_oJ7NHIMULZy76qKVl5lMxvhH1RlDhyJKneJBloVC-eUW';

        }elseif($location=="Central Park West" || $location=="Central Park South"
            || $location=="Grand Army Plaza" || $location=="High Bridge Park"
            || $location=="Riverside Park" || $location=="East River Park" ){
            $client_id = 'ATkdjMio7RqlUYJV80NAQbrSFjVP9GUCvDlXrKpL-myiwc4HKQRTnKzdmsoTMFGVDS2Ik3k_l4-gweFH';
            $secret = 'ELia830Mmc_Ws4F8dLw3L_Q4E3eH8Cw1nZRAz4eZngdoLtE80DsoN6UjdH7K_9r24_wxWJG9ku7u4nMs';

        }else{
            $client_id = 'AfnFoI1-bZU-4niJYOjwVEIDEBQHsPayvi_fF6U_kfuMSH0afJNTy79wrvjD5x58nbF6wrOiM6j5bhhc';
            $secret = 'ECL6fi7TzHeKrQeBBUjgaHVu7yMgsBxoztC_oJ7NHIMULZy76qKVl5lMxvhH1RlDhyJKneJBloVC-eUW';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'Accept-Language: en_US'
        ));
//        curl_setopt($ch, CURLOPT_URL,"https://api.sandbox.paypal.com/v1/oauth2/token");
        curl_setopt($ch, CURLOPT_URL,"https://api.paypal.com/v1/oauth2/token");

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$client_id:$secret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $data = json_decode($server_output);
//        dd($data);
//        if(array_key_exists('error_description', $data) ) {
////            CREDIT_CARD_CVV_CHECK_FAILED
//            if($data->{'error_description'}=='Client Authentication failed'){
//                session(['error'=>'Client Authentication failed']);
//            }
//
//            return redirect()->route('agent.rentOrderSubmitGet');
//        }

        return $data->access_token;
    }

    public function makePPPmt(Request $request){

        $token = $this->getPPToken($request->location);
        $tmp = explode('/', $request->cc_expiration);
        $expire_month = intval(trim($tmp[0]));
//        dd($request->cc_expiration);
//        $expire_year = intval(trim($tmp[1]));

        if(strlen(trim($tmp[1]))==2){
            $expire_year = 2000+ intval(trim($tmp[1]));
        }else{
            $expire_year = intval(trim($tmp[1]));
        }

        $cc_number = preg_replace('/\s+/', '', $request->cc_number);

//        4710717577717020
        //payment
        $data_json = array("intent"=>"sale",
            "redirect_urls"=>array(
                "return_url"=>"http://127.0.0.1:8000/bigbike/agent/rent/order",
                "cancel_url"=>"http://127.0.0.1:8000/bigbike/agent/main"
            ),
            "payer"=>array(
                "payment_method"=>"credit_card",
                "funding_instruments"=>array(
                    array(
                        "credit_card"=>array(
                            "number"=> $cc_number,
                            "type"=>$request->cc_type,
                            "expire_month"=>$expire_month,
                            "expire_year"=>$expire_year,
                            "cvv2"=>$request->cc_cvc,
                            "first_name"=>$request->cc_firstname,
                            "last_name"=>$request->cc_lastname,
//                            "billing_address"=>array(
//                                "line1"=>"111 First Street",
//                                "city"=>"Saratoga",
//                                "state"=>"CA",
//                                "postal_code"=>"95070",
//                                "country_code"=>"US"
//                            )
                        )
                    )
                )
            ),
            "transactions"=>array(
                array(
                    "amount"=>array(
//                        "total"=> Session::get('total_price_after_tax'),
                        "total"=> '0.01',
                        "currency"=>"USD"
                    )
                )
            )
        );

        Session::forget('total_tour_price_after_tax');


        $data_json = json_encode($data_json);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Bearer '.$token
        ));
//        curl_setopt($ch, CURLOPT_URL,"https://api.sandbox.paypal.com/v1/payments/payment");
        curl_setopt($ch, CURLOPT_URL,"https://api.paypal.com/v1/payments/payment");

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
        curl_close ($ch);
        $data = json_decode($server_output);

//        dd($data);

//        if(array_key_exists('message', $data) ) {
////            CREDIT_CARD_CVV_CHECK_FAILED
////            dd($data->{'message'});
//            if($data->{'message'}=="Credit card was refused."){
//                session(['error'=>'Credit card was refused']);
//            }else if($data->{'message'}=='Credit card CVV check failed'){
//                session(['error'=>'Credit Card Refused']);
//            }else {
//                session(['error'=>$data->{'message'}]);
//            }
//            return redirect()->route('agent.rentOrder');
//        }
        return $data;
    }

    public function getLocationTable($location){
        if($location=='Central Park West'){
            $table = 'cpw';
        }elseif ($location=='Central Park South'){
            $table = 'cps';
        }elseif ($location=='Grand Army Plaza'){
            $table = 'gap';
        }elseif ($location=='High Bridge Park'){
            $table = 'hbp';
        }elseif ($location=='Riverside Park'){
            $table = 'rp';
        }elseif ($location=='East River Park'){
            $table = 'erp';
        }else{
            $table = null;
        }
        if($table!=null){
            $num = DB::table($table)->insertGetId(['num'=>1]);
        }else{
            $num=null;
        }
        return array($num,$table);
    }

    public function showPartnerReport(Request $request){
        return view("bigbike.partner.show-report");
    }

    public function partnerReport(Request $request){

        $start_date = explode('/', $request->start_date);
        $end_date = explode('/', $request->end_date);
        if(Auth::user()->email=="dx285@nyu.edu"){
            $location = "203 West 80th Street";
//            $location = "203W 58th Street";

        }else{
            $location = Auth::user()->location;
        }
//        $tix_agent = User::where('email', Auth::user()->email)->first();
        $percentage_rate = AgentPercentageList::where("user_id",Auth::user()->id)->first();
//        dd($percentage_rate->percentages);
//        Log::info("rate: ".$percentage_rate->percentages->percentage_rate);
        $rate = $percentage_rate->percentages->percentage_rate/100.00;
//        dd($rate);
//        DB::connection()->enableQueryLog();

        $agent_cc_rents = DB::connection('mysql2')->table('pos_rents_orders')
            ->where("location",$location)
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where('payment_type', 'paypal')
            ->where('order_completed', '1')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();


//        $queries = DB:p:getQueryLog();
//        dd($queries);

        $agent_cc_tours = DB::connection('mysql2')->table('pos_tours_orders')
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
            ->where("location",$location)
            ->where('payment_type', 'paypal')
            ->where('order_completed', '1')
            ->whereYear('created_at', '>=', $start_date[1])
            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '>=', $start_date[1])
//            ->whereDay('created_at', '<=', $end_date[1])
            ->whereMonth('created_at', '<=', $end_date[0])
            ->whereMonth('created_at', '>=', $start_date[0])
            ->get();

        $sum = 0;
        foreach ($agent_cc_rents as $agent_cc_rent){
            if($agent_cc_rent->agent_refund==0) {
                $sum += number_format($rate * (float)$agent_cc_rent->total_price_after_tax, 2);
            }
//            $sum += (float)$agent_cc_rent->agent_price_after_tax;

        }

        foreach ($agent_cc_tours as $agent_cc_tour){
            if($agent_cc_rent->agent_refund==0) {
                $sum += number_format($rate * (float)$agent_cc_tour->total_price_after_tax, 2);
            }
        }

        $cash_sum = 0;

//        $agent_cash_rents = DB::connection('mysql2')->table('pos_rents_orders')
////            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
//            ->where("location",$location)
//            ->where('payment_type', 'Cash')
//            ->whereYear('created_at', '>=', $start_date[1])
//            ->whereYear('created_at', '<=', $end_date[1])
////            ->whereDay('created_at', '>=', $start_date[1])
////            ->whereDay('created_at', '<=', $end_date[1])
//            ->whereMonth('created_at', '<=', $end_date[0])
//            ->whereMonth('created_at', '>=', $start_date[0])
//            ->get();
//
//        $agent_cash_tours = DB::connection('mysql2')->table('pos_tours_orders')
//            ->where("location",$location)
////            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
//            ->where('payment_type', 'Cash')
//            ->whereYear('created_at', '>=', $start_date[1])
//            ->whereYear('created_at', '<=', $end_date[1])
////            ->whereDay('created_at', '>=', $start_date[1])
////            ->whereDay('created_at', '<=', $end_date[1])
//            ->whereMonth('created_at', '<=', $end_date[0])
//            ->whereMonth('created_at', '>=', $start_date[0])
//            ->get();
//        dd($agent_cash_rents);
//        foreach ($agent_cash_rents as $agent_cash_rent){
//            if($agent_cash_rent->agent_refund==0) {
//
//                $cash_sum += (float)$agent_cash_rent->agent_price_after_tax;
////            $sum += (float)$agent_cc_rent->agent_price_after_tax;
//            }
//        }
//
//        foreach ($agent_cash_tours as $agent_cash_tour){
//            if($agent_cash_tour->agent_refund==0) {
//                $cash_sum += (float)$agent_cash_tour->agent_price_after_tax;
//            }
//        }

//        dd($agent_cc_rents);
        return view('bigbike.partner.show-report',['search'=>true,'agent_cc_rents'=>$agent_cc_rents,'agent_cc_tours'=>$agent_cc_tours,
//            'agent_cash_rents'=>$agent_cash_rents,'agent_cash_tours'=>$agent_cash_tours,
            'sum'=>$sum,'cash_sum'=>$cash_sum,
            'start_date'=>$start_date[0].'/'.$start_date[1],'end_date'=>$end_date[0].'/'.$end_date[1]]);
//        return view('bigbike.agent.show-report');

    }

    public function showReservationPage(){
        if(Auth::user()->email=="info@larrysfreewheeling.com" || Auth::user()->email=="dx285@nyu.edu"){
//            $location = "208 West 80th Street";
            $location = "301 Cathedral Pkwy";
//            dd("here");

        }else{
            $location = Auth::user()->location;
        }
        $agent_rent_table= DB::connection('mysql2')->table('pos_rents_orders')->where('order_completed', 1)->where('reservation', 1)->where('served', 0)->where('location', $location)->orderBy('date', 'asc')->get();
//        $agent_rent_table= DB::table('pos_rents_orders')->where('order_completed', 1)->where('reservation', 1)->where('served', 0)->where('location', $location)->orderBy('date', 'asc')->get();
//        dd($agent_rent_table);
//        dd($agent_rent_table);
        $agent_tour_table= DB::connection('mysql2')->table('pos_tours_orders')->where('order_completed', 1)->where('reservation', 1)->where('served', 0)->where('location', $location)->orderBy('date', 'asc')->get();

        return view('bigbike.partner.reservation',['agent_rent_table'=>$agent_rent_table,'agent_tour_table'=>$agent_tour_table]);
    }

    public function served(Request $request){
//        dd("here");
        DB::connection('mysql2')->table('pos_rents_orders')
            ->where('id', $request->id)
            ->update([
                'returned'=>1,
                'served'=>1,
                'served_date'=>date("Y-m-d H:i:s"),
                'returned_cashier'=>Auth::user()->email,
                'returned_date'=>date("Y-m-d H:i:s")
            ]);
        return redirect()->route('agent.showReservationPage');
    }

}
