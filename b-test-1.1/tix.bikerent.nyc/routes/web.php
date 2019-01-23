<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/',[
    'uses' => 'BigBike\Agent\AgentController@loginAgent',
    'as' => 'agent.index',
    'middleware' => 'auth'
]);

Route::get('/404',[
    'uses' => 'BigBike\Agent\AgentController@go404',
    'as' => 'agent.404'
//    'middleware' => 'auth'
]);

Route::get('/screentest',[
    'uses' => 'BigBike\TestController@screentest',
//    'middleware' => 'auth'
]);


Route::group(['prefix' => 'user'], function(){
    Route::group(['middleware' => 'guest'], function(){
//        Route::group(['middleware' => ['role:admin']], function () {

            Route::get('/signup',[
            'uses' => 'UserController@getSignup',
            'as' => 'user.signup'
            ]);


            Route::post('/signup', [
                'uses' => 'UserController@postSignup',
                'as' => 'user.signup'
            ]);
//        });

        Route::get('/signin',[
            'uses' => 'UserController@getSignin',
            'as' => 'user.signin'
        ]);

        Route::post('/signin',[
            'uses' => 'UserController@postSignin',
            'as' => 'user.signin'
        ]);

        Route::get('/terms',[
            'uses' => 'UserController@getTerms',
            'as' => 'user.terms'
        ]);
    });


    Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile',[
            'uses' => 'UserController@getProfile',
            'as' => 'user.profile'
        ]);

        Route::get('/logout',[
            'uses' => 'UserController@getLogout',
            'as' => 'user.logout'
        ]);

        Route::get('/resetpw',[
            'uses' => 'UserController@resetpw',
            'as' => 'user.resetpw'
        ]);

        Route::post('/resetpw',[
            'uses' => 'UserController@resetpassword',
            'as' => 'user.resetpww'
        ]);


    });

});

//Route::get('showStripe',[
//    'uses' => 'UserController@showStripe',
//    'as' => 'admin.showStripe'
//]);
//
//Route::post('TestStripe',[
//    'uses' => 'UserController@TestStripe',
//    'as' => 'admin.TestStripe'
//]);

Route::group(['prefix' => 'bigbike/admin'],function(){
    Route::group(['middleware' => ['role:admin']], function () {
        Route::group(['middleware' => 'auth'], function(){


            Route::get('month/random',[
                'uses' => 'BigBike\TestController@assignRandomNumber',
                'as' => 'month.random'
            ]);

            Route::get('month/report',[
                'uses' => 'BigBike\TestController@getPosMonthReport',
                'as' => 'monthreport'
            ]);

            Route::post('month/report',[
                'uses' => 'BigBike\TestController@runTest',
                'as' => 'runTest'
            ]);

            Route::get('main',[
                'uses' => 'BigBike\Admin\AdminController@getMainPage',
                'as' => 'admin.main'
            ]);

            Route::get('report',[
                'uses' => 'BigBike\Admin\AdminController@getReport',
                'as' => 'admin.report'
            ]);

            Route::post('agent',[
                'uses' => 'BigBike\Admin\AdminController@getAgentReport',
                'as' => 'admin.agent'
            ]);

            Route::post('agent/detail',[
                'uses' => 'BigBike\Admin\AdminController@getAgentMonthlyDetail',
                'as' => 'admin.agentDetail'
            ]);

            Route::get('agent/monthly',[
                'uses' => 'BigBike\Admin\AdminController@getMonthForm',
                'as' => 'admin.monthly'
            ]);

            Route::post('agent/month',[
                'uses' => 'BigBike\Admin\AdminController@getMonthReport',
                'as' => 'admin.monthlyReport'
            ]);

            Route::get('delete/{id}',[
                'uses' => 'BigBike\Admin\AdminController@delete',
                'as' => 'admin.delete'
            ]);

            Route::get('restore/{id}',[
                'uses' => 'BigBike\Admin\AdminController@restore',
                'as' => 'admin.restore'
            ]);

            Route::get('update_role/{id}/{role_id}',[
                'uses' => 'BigBike\Admin\AdminController@UpdateRole',
                'as' => 'admin.update_role'
            ]);
        });

    });
});
//Route::resource('users','UserController');
//Route::resource('roles','RoleController');

//Route::group(['middleware' => 'auth'], function(){
Route::group(['middleware' => ['role:big_agent|tour_operator|store_partner|35_agent']], function () {

Route::group(['prefix' => 'bigbike/agent'],function(){
//    Route::resource('users','UserController');

    Route::get('/showBTPage',[
        'uses' => 'BigBike\Agent\BrainTreeController@showBTPage',
        'as' => 'agent.showBTPage'
    ]);

    Route::post('/payBT',[
        'uses' => 'BigBike\Agent\BrainTreeController@processBTTransaction',
        'as' => 'agent.payBT'
    ]);


    Route::get('/create',[
        'uses' => 'UserController@create',
        'as' => 'agent.getResetPage'
    ]);


    Route::get('/get-reset-page',[
        'uses' => 'BigBike\Agent\AgentController@getResetPage',
        'as' => 'agent.getResetPage'
    ]);

    Route::post('/get-email',[
        'uses' => 'BigBike\Agent\AgentController@getEmail',
        'as' => 'agent.getEmail'
    ]);

    Route::get('/show-reset-password-page',[
        'uses' => 'BigBike\Agent\AgentController@getResetPage',
        'as' => 'agent.getGetResetPage'
    ]);

    Route::post('/show-reset-password-page',[
        'uses' => 'BigBike\Agent\AgentController@showResetPasswordPage',
        'as' => 'agent.showResetPasswordPage'
    ]);

//    Route::get('/send-reset-email',[
//        'uses' => 'BigBike\Agent\AgentController@sendResetEmail',
//        'as' => 'agent.sendResetEmail'
//    ]);

    Route::post('/reset-password',[
        'uses' => 'BigBike\Agent\AgentController@resetPassword',
        'as' => 'agent.resetPassword'
    ]);

    Route::get('/contact',[
        'uses' => 'BigBike\Agent\AgentController@contact',
        'as' => 'agent.contact'
    ]);

    Route::group(['middleware' => 'auth'], function(){

        Route::get('/main',[
            'uses' => 'BigBike\Agent\AgentController@loginAgent',
            'as' => 'agent.main'
        ]);


        Route::group(['prefix' => 'rent'],function(){

            Route::get('ticket',[
                'uses' => 'BigBike\Agent\RentController@printTicket',
                'as' => 'agent.rentTicket'
            ]);


            Route::get('order',[
                'uses' => 'BigBike\Agent\RentController@getRent',
                'as' => 'agent.rentOrder'
            ]);

            Route::get('order-cal',[
                'uses' => 'BigBike\Agent\RentController@calculate',
                'as' => 'agent.rentOrderCal'
            ]);

            Route::get('order-submit',[
                'uses' => 'BigBike\Agent\RentController@getCheckout',
                'as' => 'agent.rentOrderSubmitGet'
            ]);

            Route::post('order-submit',[
                'uses' => 'BigBike\Agent\RentController@submitForm',
                'as' => 'agent.rentOrderSubmit'
            ]);

            Route::get('order-checkout',[
                'uses' => 'BigBike\Agent\RentController@checkout',
                'as' => 'agent.rentOrderCheckout'
            ]);

            Route::post('cc-checkout',[
                'uses' => 'BigBike\Agent\RentController@postCCCheckout',
                'as' => 'agent.ccCheckout'
            ]);

            Route::post('pp-checkout',[
                'uses' => 'BigBike\Agent\RentController@postppCheckout',
                'as' => 'agent.ppCheckout'
            ]);

            Route::get('receipt',[
                'uses' => 'BigBike\Agent\RentController@printReceipt',
                'as' => 'agent.rentReceipt'
            ]);
        });


        Route::group(['prefix' => 'tour'],function(){

            Route::get('testCalendar',[
                'uses' => 'BigBike\Agent\TourController@handle',
                'as' => 'agent.handle'
            ]);

            Route::get('order',[
                'uses' => 'BigBike\Agent\TourController@getOrder',
                'as' => 'agent.tourOrder'
            ]);

            Route::get('order-cal',[
                'uses' => 'BigBike\Agent\TourController@calculate',
                'as' => 'agent.tourOrderCal'
            ]);

            Route::post('order-submit',[
                'uses' => 'BigBike\Agent\TourController@submitForm',
                'as' => 'agent.tourOrderSubmit'
            ]);

            Route::post('cc-checkout',[
                'uses' => 'BigBike\Agent\TourController@postCCCheckout',
                'as' => 'agent.tourccCheckout'
            ]);

            Route::get('receipt',[
                'uses' => 'BigBike\Agent\TourController@printReceipt',
                'as' => 'agent.tourReceipt'
            ]);

            Route::get('ticket',[
                'uses' => 'BigBike\Agent\TourController@printTicket',
                'as' => 'agent.tourTicket'
            ]);

            Route::post('pp-tour-checkout',[
                'uses' => 'BigBike\Agent\TourController@postppCheckout',
                'as' => 'agent.ppTourCheckout'
            ]);

        });


        Route::get('/report',[
            'uses' => 'BigBike\Agent\AgentController@getReportForm',
            'as' => 'agent.report'
        ]);

        Route::post('/show-report',[
            'uses' => 'BigBike\Agent\AgentController@showReport',
            'as' => 'agent.showReport'
        ]);

        Route::get('/partner-report',[
            'uses' => 'BigBike\Partner\PartnerController@showPartnerReport',
            'as' => 'partner.report'
        ]);

        Route::post('/partner-show-report',[
            'uses' => 'BigBike\Partner\PartnerController@partnerReport',
            'as' => 'partner.showReport'
        ]);

        Route::get('/partner-show-reservation',[
            'uses' => 'BigBike\Partner\PartnerController@showReservationPage',
            'as' => 'agent.showReservationPage'
        ]);

        Route::post('/partner-bikerent',[
            'uses' => 'BigBike\Partner\PartnerController@showBikeRent',
            'as' => 'agent.showBikeRent'
        ]);

        Route::get('/partner-served/{id}',[
            'uses' => 'BigBike\Partner\PartnerController@served',
            'as' => 'agent.served'
        ]);



    });

});
});

//Route::get('/bigbike/agent/tour-order-cal',[
//    'uses' => 'ProductController@calculateTour',
//    'as' => 'agent.tourOrderCal'
//]);

