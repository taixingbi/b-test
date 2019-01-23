<?php

namespace App\Http\Controllers\BigBike\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;
use Auth;
use App\User;
use App\AgentPercentageList;
use App\AgentPercentage;
use App\ModelHasRole;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{

    public function getMainPage(){
        return view('bigbike.admin.admin');
    }

    public function getReport(){

        $id_list = DB::table("model_has_roles")->pluck("model_id");
        $agents = User::whereIn('id', $id_list)->get();
        $roles = DB::table("roles")->whereNotIn('id',[2])->get();
//        dd($agents[0]);
//        dd($agents[0]->roles->role->name);
//        dd($agent_list);
        return view('bigbike.admin.agent-list',['agents'=>$agents,'ids'=>$id_list,'roles'=>$roles]);
    }

    public function delete($id){
//        dd("here");
        $id = User::find( $id );
//        $id->delete();
        $id->deleted_at=date("Y-m-d H:i:s");
        $id->save();

        return redirect()->route('admin.report');

    }

    public function restore($id){

//        dd("here");
        $id = User::find( $id );
//        $id->delete();
        $id->deleted_at=null;
        $id->save();

        return redirect()->route('admin.report');

    }

    public function UpdateRole($id, $role_id){
//        dd("test");
        if($role_id!=5) {
            $agent = AgentPercentageList::where('user_id', $id)->first();
            $agent_percentage = AgentPercentage::where("role_id", $role_id)->first();
            $agent->percentage_id = $agent_percentage->id;
            $agent->save();
        }
//        $model_role = ModelHasRole::where("model_id",$id)->first();
////        dd($model_role);
//        $model_role->role_id = $role_id;
//        $model_role->save();

        DB::table('model_has_roles')
            ->where('model_id', $id)
            ->update(['role_id' => $role_id]);


        return redirect()->route('admin.report');
    }

    public function getAgentReport(Request $request){
        $date = explode('/', $request->admin_date);

        $agent_rent_cc = DB::connection('mysql2')->table('agent_rents_orders')
            ->where('agent_email', $request->admin_agent)
            ->where('payment_type', 'credit_card')
            ->where('order_completed', 1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
            ->sum('total_price_after_tax');

        $agent_rent_cash = DB::connection('mysql2')->table('agent_rents_orders')
            ->where('agent_email', $request->admin_agent)
            ->where('payment_type', 'cash')
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
            ->sum('total_price_after_tax');

        $agent_tour_cc = DB::connection('mysql2')->table('agent_tours_orders')
            ->where('agent_email', $request->admin_agent)
            ->where('payment_type', 'credit_card')
            ->where('order_completed', 1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
            ->sum('total_price_after_tax');

        $agent_tour_cash = DB::connection('mysql2')->table('agent_tours_orders')
            ->where('agent_email', $request->admin_agent)
            ->where('payment_type', 'cash')
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
            ->sum('total_price_after_tax');


//        $agents = DB::table('agent_rents_orders')->where('agent_email', $request->admin_agent)->where('payment_type', $payment)->get();
//        $agents = DB::table('agent_rents_orders')->where('agent_email', $request->admin_agent)->where('payment_type', '')->get();
//        return view('bigbike.admin.agent_report',['agent_cc'=>$agent_cc, 'agent_cash'=>$agent_cash,'date'=>$request->admin_date]);
        return ['agent_rent_cc'=>$agent_rent_cc, 'agent_rent_cash'=>$agent_rent_cash,'agent_tour_cc'=>$agent_tour_cc, 'agent_tour_cash'=>$agent_tour_cash,'date'=>$request->admin_date];
    }

    public function getMonthForm(){
        return view('bigbike/admin/monthly');
    }

    public function getMonthReport(Request $request){
        $date = explode('/', $request->admin_date);
//        dd($date);

        $agent_cc_rents = DB::connection('mysql2')->table('pos_rents_orders')
//            ->where("cashier_email","xdrealmadrid@gmail.com")
//            ->select('agent_email',DB::raw('total_price_after_tax'))
            ->where('payment_type', 'Credit Card')
            ->where('order_completed', 1)
            ->whereNotNull("agent_email")
            ->where("agent_refund","<>",1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
//            ->groupBy('agent_email')
            ->get();
//        dd($agent_cc_rents);
        $agent_cc_tours = DB::connection('mysql2')->table('pos_tours_orders')
//            ->select('agent_email',DB::raw('total_price_after_tax'))
            ->where('payment_type', 'Credit Card')
            ->where("agent_refund","<>",1)
            ->whereNotNull("agent_email")
            ->where('order_completed', 1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
//            ->groupBy('agent_email')
            ->get();

        $cc_arr = [];
        $role_arr = [];
        foreach($agent_cc_rents as $agent_cc_rent){
            if(array_key_exists($agent_cc_rent->agent_email,$cc_arr)){
                $cc_arr[$agent_cc_rent->agent_email] += (float)$agent_cc_rent->total_price_after_tax;
            }else{
                $cc_arr[$agent_cc_rent->agent_email] = (float)$agent_cc_rent->total_price_after_tax;
//                $cc_arr[$agent_cc_rent->agent_email] = (float)$agent_cc_rent->total_price_after_tax;

                $agent = User::where('email', $agent_cc_rent->agent_email)->first();
                if($agent->hasRole('big_agent')){
                    $role_arr[$agent_cc_rent->agent_email] = "big_agent";
                }
                elseif($agent->hasRole('tour_operator')){
                    $role_arr[$agent_cc_rent->agent_email] = "tour_operator";
                }

            }
        }
        foreach($agent_cc_tours as $agent_cc_tour){
            if(array_key_exists($agent_cc_tour->agent_email,$cc_arr)){
                $cc_arr[$agent_cc_tour->agent_email] += (float)$agent_cc_tour->total_price_after_tax;
            }else{
                $cc_arr[$agent_cc_tour->agent_email] = (float)$agent_cc_tour->total_price_after_tax;

                $agent = User::where('email', $agent_cc_tour->agent_email)->first();
                if($agent->hasRole('big_agent')){
                    $role_arr[$agent_cc_tour->agent_email] = "big_agent";
                }
                elseif($agent->hasRole('tour_operator')){
                    $role_arr[$agent_cc_tour->agent_email] = "tour_operator";
                }
            }
        }

//        dd($cc_arr);
        $agent_cash_rents = DB::connection('mysql2')->table('pos_rents_orders')
//            ->select('agent_email',DB::raw('SUM(total_price_after_tax) as total_price_after_tax'),DB::raw('SUM(agent_price_after_tax) as agent_price_after_tax'))
            ->where('payment_type', 'Cash')
            ->where("agent_refund",'<>',1)
            ->whereNotNull("agent_email")
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
//            ->groupBy('agent_email')
            ->get();

        $agent_cash_tours = DB::connection('mysql2')->table('pos_tours_orders')
//            ->select('agent_name',DB::raw('SUM(total_price_after_tax) as total_price_after_tax'),DB::raw('SUM(agent_price_after_tax) as agent_price_after_tax'))
            ->where('payment_type', 'Cash')
            ->where("agent_refund",'<>',1)
            ->whereNotNull("agent_email")
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])
//            ->groupBy('agent_name')
            ->get();

//        dd($agent_cash_tours);
        $cash_arr = [];
        $cash_agent_arr = [];
        foreach($agent_cash_rents as $agent_cash_rent){
            if(array_key_exists($agent_cash_rent->agent_email,$cash_arr)){
//                $cash_arr[$agent_cash_rent->agent_email] += (float)$agent_cash_rent->total_price_after_tax-(float)$agent_cash_rent->agent_price_after_tax;
                $cash_arr[$agent_cash_rent->agent_email] += (float)$agent_cash_rent->agent_price_after_tax;

//                $cash_agent_arr[$agent_cash_rent->agent_email] += (float)$agent_cash_rent->agent_price_after_tax;
            }else {
//                $cash_arr[$agent_cash_rent->agent_email] = (float)$agent_cash_rent->total_price_after_tax-(float)$agent_cash_rent->agent_price_after_tax;
                $cash_arr[$agent_cash_rent->agent_email] = (float)$agent_cash_rent->agent_price_after_tax;
                $agent = User::where('email', $agent_cash_rent->agent_email)->first();

                if($agent->hasRole('big_agent')){
                    $role_arr[$agent_cash_rent->agent_email] = "big_agent";

                }

                elseif($agent->hasRole('tour_operator')){
                    $role_arr[$agent_cash_rent->agent_email] = "tour_operator";

                }
//                $cash_agent_arr[$agent_cash_rent->agent_email] = (float)$agent_cash_rent->agent_price_after_tax;
            }
        }
        foreach($agent_cash_tours as $agent_cash_tour){
            if(array_key_exists($agent_cash_tour->agent_email,$cash_arr)){
//                $cash_arr[$agent_cash_tour->agent_name] += (float)$agent_cash_tour->total_price_after_tax-(float)$agent_cash_tour->agent_price_after_tax;
                $cash_arr[$agent_cash_tour->agent_email] += (float)$agent_cash_tour->agent_price_after_tax;


            }else{
//                $cash_arr[$agent_cash_tour->agent_name] = (float)$agent_cash_tour->total_price_after_tax-(float)$agent_cash_tour->agent_price_after_tax;
                $cash_arr[$agent_cash_tour->agent_email] = (float)$agent_cash_tour->agent_price_after_tax;
                $agent = User::where('email', $agent_cash_tour->agent_email)->first();

                if($agent->hasRole('big_agent')){
                    $role_arr[$agent_cash_tour->agent_email] = "big_agent";

                }

                elseif($agent->hasRole('tour_operator')){
                    $role_arr[$agent_cash_tour->agent_email] = "tour_operator";

                }
            }
        }

        return view('bigbike/admin/month-detail',
            ['cc_arr'=>$cc_arr,
            'cash_arr'=>$cash_arr,
            'cash_agent_arr'=>$cash_agent_arr,
            'date'=>$request->admin_date,
            "role_arr"=>$role_arr]);
//        return view('bigbike/admin/month-detail');
    }

    public function getAgentMonthlyDetail(Request $request){

        $date = explode('/', $request->date_pay);

        $agent_cc_rents = DB::connection('mysql2')->table('agent_rents_orders')
            ->where('agent_email', $request->agent_pay)
            ->where('payment_type', 'credit_card')
            ->where('order_completed', 1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])->get();

        $agent_cc_tours = DB::connection('mysql2')->table('agent_tours_orders')
            ->where('agent_email', $request->agent_pay)
            ->where('payment_type', 'credit_card')
            ->where('order_completed', 1)
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])->get();

        $sum = 0;
        $agent_sum = 0;
        foreach ($agent_cc_rents as $agent_cc_rent){
            $sum += (float)$agent_cc_rent->total_price_after_tax;
            $agent_sum += number_format(0.3*(float)$agent_cc_rent->total_price_after_tax,2);
        }

        foreach ($agent_cc_tours as $agent_cc_tour){
            $sum += (float)$agent_cc_tour->total_price_after_tax;
            $agent_sum += number_format(0.3*(float)$agent_cc_tour->total_price_after_tax,2);
        }

        $sum = number_format($sum*0.7,2);

        $agent_cash_rents = DB::connection('mysql2')->table('agent_rents_orders')
            ->where('agent_email', $request->agent_pay)
            ->where('payment_type', 'cash')
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])->get();

        $agent_cash_tours = DB::connection('mysql2')->table('agent_tours_orders')
            ->where('agent_email', $request->agent_pay)
            ->where('payment_type', 'cash')
            ->whereYear('created_at', '=', $date[1])
            ->whereMonth('created_at', '=', $date[0])->get();

        $cash_sum = 0;
        foreach ($agent_cash_rents as $agent_cash_rent){
            if($agent_cash_rent->agent_refund) {
                $cash_sum += (float)$agent_cash_rent->total_price_after_tax;
            }
        }

        foreach ($agent_cash_tours as $agent_cash_tour){
            if($agent_cash_rent->agent_refund) {
                $cash_sum += (float)$agent_cash_tour->total_price_after_tax;
            }
        }

        return view('bigbike/admin/agent-detail',['agent_cc_rents'=>$agent_cc_rents, 'agent_cc_tours'=>$agent_cc_tours,
            'agent_cash_rents'=>$agent_cash_rents, 'agent_cash_tours'=>$agent_cash_tours,'sum'=>$sum,'agent_sum'=>$agent_sum,
            'date_pay'=>$request->date_pay, 'cash_sum'=>$cash_sum,'agent_pay'=>$request->agent_pay]);
    }



}
