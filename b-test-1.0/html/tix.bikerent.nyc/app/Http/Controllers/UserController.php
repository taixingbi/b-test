<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Http\Requests;
use App\AgentPercentage;
use App\AgentPercentageList;
use App\ModelHasRole;
use Auth;
use Illuminate\Support\Facades\Session;
use Log;
use Spatie\Permission\Models\Role;
use Hash;
//use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function getSignup(){


//        $role = Role::create(['name' => 'admin']);
//        $role = Role::create(['name' => 'big_agent']);
//        $role = Role::create(['name' => 'tour_operator']);

//        $permission = Permission::create(['name' => 'edit articles']);
////        $role->givePermissionTo($permission);
//        $permission->assignRole($role);

        return view('user.signup');
    }
//        $data = array('name' => 'vikas', 'message' => 'test message');
//        Mail::send('emails.welcome', $data, function ($message) use($user) {
//
//            $message->from('s.tcukanov@gmail.com', 'Learning Laravel');
//
//           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
////            $message->to($user->email, $user->name)->subject('Thank you for registration');
//
//
//        });


    public function postSignup(Request $request){
        $this->validate($request,[
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $user = new User([
            'email' => $request->input('email'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'full_name' => $request->input('first_name').' '.$request->input('last_name'),
            'password' => bcrypt($request->input('password'))
        ]);

        $user->save();

        $user->assignRole($request->input('roles'));

//        $modelHasRole = new ModelHasRole([
//            "role_id"=>$role->id,
//            "model_type"=>"App\User",
//            "model_id"=>$user->id
//        ]);
//        $modelHasRole->save();
//        Log::info("id: ".$user->id);
        //$this->signupWel($user);
        if($request->input('roles') != "store_partner") {
            $role = Role::where("name", $request->input('roles'))->first();
            $agent_percentage = AgentPercentage::where('role_id', $role->id)->first();
            $agent_percentage_list = new AgentPercentageList([
                'user_id' => $user->id,
                'percentage_id' => $agent_percentage->id
            ]);
            $agent_percentage_list->save();
        }
        Auth::login($user);
        session(['name'=>$request->input('first_name').' '.$request->input('last_name')]);


        if($user->hasRole('admin')){
            return redirect()->route('admin.report');

        }

        if($user->hasRole('store_partner')){
            return redirect()->route('agent.main');

        }

        if(Session::has('oldUrl')) {
            $oldUrl = Session::get('oldUrl');
            Session::forget('oldUrl');
            return redirect()->to($oldUrl);
        }
        //return redirect()->route('user.profile');
        return redirect()->route('agent.main');
    }

    public function signupWel($user){
        $data = array('name' => 'BigBike', 'msg' => 'Welcome to BigBike');
//        Mail::send('emails.signup-welcome', $data, function ($message) use($user) {
//
//            $message->from('vouchers@bikerent.nyc', 'Welcome to BikeRent tickets system');
//
////           $message->to('support@my3dcrestwhite.ru')->subject('Thank you for registration');
//            $message->to($user->email)->subject('Thank you for registration');
//
//        });
    }

    public function getSignin(){
        return view('user.signin');
    }

    public function postSignin(Request $request){

        $this->validate($request,[
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ])){

            $agent = User::where('email', $request->email)->first();
//            Log::info("admin: ".$agent->hasRole('admin'));

//            dd($agent->hasRole('admin'));
            if($agent->hasRole('admin')){
                return redirect()->route('admin.report');

            }

            if($agent->hasRole('store_partner')){
                return redirect()->route('agent.main');

            }

//            dd("here");


            session(['name'=>$agent->first_name.' '.$agent->last_name]);
            if(Session::has('oldUrl')) {
                $oldUrl = Session::get('oldUrl');
                Session::forget('oldUrl');
                return redirect()->to($oldUrl);
            }
            session(['name'=>$agent->first_name.' '.$agent->last_name]);
            //return redirect()->route('user.profile');
            return redirect()->route('agent.rentOrder');
        }
        return redirect()->back()->with('error', "Email or Password is invalid");
    }

    public function getLogout(){
//        $agent = User::where('email', Auth::user()->email)->first();
//        $agent->assignRole("admin");
//        Log::info("admin: ".$agent->hasRole('admin'));

        Auth::logout();
        Session::forget('name');
        //return redirect()->back();
        return redirect()->route('user.signin');
    }

    public function index(Request $request)
    {
//        $data = User::orderBy('id','DESC')->paginate(5);
//        dd($data);
        $data = User::role('admin')->paginate(5); // Returns only users with the role 'writer'
//        dd($users);
        return view('user.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function getTerms() {
        return view('user.terms');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

    public function resetpw(Request $request){
        $email = Auth::user()->email;
        return view('user.reset',["email"=>$email]);
    }

    public function resetpassword(Request $request){
        try {
            $user = Auth::user();
            if(!empty($request->input('email'))){
                $user->email = trim($request->input('email'));
            }
            if(!empty($request->input('first_name'))){
                $user->first_name = trim($request->input('first_name'));
            }
            if(!empty($request->input('last_name'))){
                $user->last_name = trim($request->input('last_name'));
            }
            if(!empty($request->input('password'))){
                $user->password = bcrypt(trim($request->input('password')));
            }

            $user->save();

//            User::where('email', $request->input('email'))
//                ->update(['password' => bcrypt($request->input('password'))]);
        }catch(Exception $e){
            session(["rent_price_error"=>$e->getMessage()]);
            return redirect()->route('agent.rentOrder');

        }
        session(["rent_price_error"=>"User Info Updated"]);
        return redirect()->route('agent.rentOrder');
    }

    public function showStripe(Request $request){
//        return view("payment.stripe_default");
        return view("payment.stripe");
    }

    public function TestStripe(Request $request){
//        $user = Auth::user();
        $user = User::where("email","partner@test.com")->first();

//        $user->newSubscription('main', 'premium')->create("tok_1CzEOh2eZvKYlo2CpqwJMAD1");

        $user->newSubscription('main', 'plan_DQ59ewPawMTVEM')->create($request->stripeToken);
//        dd("test");
        dd("subscription success, sign up as another user to test this");
        Log::info("token");
    }

}
