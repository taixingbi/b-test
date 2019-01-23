<?php

namespace App\Http\Controllers\BigBike;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use App\User;
use App\AgentPercentageList;
use App\PosTestOrder;
use Stripe\Stripe;
use Auth;
use Illuminate\Support\Facades\DB;
use Mail;
use Log;
use DateTime;
use Carbon\Carbon;


class TestController extends Controller
{

    private $months = ["January","February","March","April","May","June","July","August","September","October","November","December"];

    public function getPosMonthReport(){
        $locations = DB::connection('mysql3')->table('locations')->where("is_parked",0)->get();
        return view('bigbike/admin/pos-month',['locations'=>$locations]);
    }

    public function assignRandomNumber(Request $request){
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', 300);
//        $locations = DB::connection('mysql3')->table("locations")->get();
//        foreach ($locations as $location) {
//            $tests = PosTestOrder::where("location",$location->title)->where("random",2708835)->get();
        $tests = PosTestOrder::where("location","228 7th Ave")->where("random",2708835)->get();
        foreach ($tests as $test) {
                $test->random = rand(1, 10000000);
                $test->save();
            }
//        }
//        $test = PosTestOrder::query()->update(array('random' => rand(1,10000000)));
        dd("here");
    }

    public function runTest(Request $request)
    {

        ini_set('memory_limit', '2048M');

//        $start_date = explode('/', $request->start_date);
//        $end_date = explode('/', $request->end_date);
        foreach ($this->months as $mon) {
            $date = explode('/', $request->admin_date);
            $month = ltrim($date[0], '0') - 1;
//            $first = "first day of " . $this->months[$month] . " " . trim($date[1]);
//            $last = "last day of " . $this->months[$month] . " " . trim($date[1]);
            $first = "first day of " . $mon . " " . trim($date[1]);
            $last = "last day of " . $mon . " " . trim($date[1]);
//            dd($first);
            $begin = new Carbon($first);
//        dd($begin);
            $end = new Carbon($last);
//        dd($end);
//        $dt = Carbon::parse($begin);


            //count how many every day
//        $day_cash = DB::connection('mysql3')->table('pos_rents_orders')
//            ->where("location",$request->location)
////            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
//            ->where('payment_type', 'Cash')
//            ->where('order_completed', '1')
//            ->whereYear('created_at', '=', $date[1])
////            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '=', $begin->day)
////            ->whereDay('created_at', '<=', $end_date[1])
//            ->whereMonth('created_at', '=', $date[0])
////            ->whereMonth('created_at', '>=', $start_date[0])
//            ->get();
//        dd($day_cash);

            for ($i = $begin; $i <= $end; $i->modify('+1 day')) {

//            dd($i->format("Y-m-d"));
//            if ($i->day == 2) {
//                dd($i->day);

//                Log::info("day: " . $i->day . " year: " . $date[1] . " month: " . $date[0]);
                $day_cash = PosTestOrder::where("location", $request->location)
//            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
                    ->where('payment_type', 'Cash')
                    ->where('order_completed', '1')
                    ->whereYear('created_at', '=', $date[1])
//            ->whereYear('created_at', '<=', $end_date[1])
//            ->whereDay('created_at', '=', $begin->day)
                    ->whereDay('created_at', '=', $i->day)
                    //            ->whereDay('created_at', '<=', $end_date[1])
                    ->whereMonth('created_at', '=', $date[0])
                    ->orderBy('customer_name', 'desc')
                    //            ->whereMonth('created_at', '>=', $start_date[0])
                    ->get();

//                dd($day_cash);
                $original_count = $day_cash->count();
                //for places like warehouse?
                if($original_count<=10) continue;
                $total_count = intval(0.9 * $original_count);
                $count = 0;
                foreach ($day_cash as $transaction) {
                    if ($count >= $total_count) {

                        Log::info("count: " . $count);
                        Log::info("total count: " . $total_count);
                        Log::info("original count: " . $original_count);
                        continue;
                    }
                    $count++;
                    $transaction->delete();
                }
//            }
            }
        }
        dd("here");

        //count by location and date


//        $agent_cc_rents = DB::connection('mysql3')->table('pos_rents_orders')
//
//            ->where("agent_email",Auth::user()->email)
////            ->where('tix_agent', $tix_agent->first_name.' '.$tix_agent->last_name)
//            ->where('payment_type', 'Cash')
//            ->where('order_completed', '1')
//            ->whereYear('created_at', '>=', $start_date[1])
//            ->whereYear('created_at', '<=', $end_date[1])
////            ->whereDay('created_at', '>=', $start_date[1])
////            ->whereDay('created_at', '<=', $end_date[1])
//            ->whereMonth('created_at', '<=', $end_date[0])
//            ->whereMonth('created_at', '>=', $start_date[0])
//            ->get();
//

    }

    public function screentest(Request $request){
        return view("payment.screentest");
    }


}
