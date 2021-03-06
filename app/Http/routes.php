<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

/*Route::group(['middleware' => ['web']], function () {
    //
});*/

Route::group(['middleware' => 'web'], function () {
    //Route::auth();

    //Homepage
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/pricing', 'HomeController@pricing');
    Route::get('/contact', 'HomeController@contact');

    //Contact submit
    Route::post('/contact', 'HomeController@handleContactSubmit');

    //payment
    Route::post('/checkout', 'PaymentController@createQuickReminderOrder');
    Route::post('/usercheckout', 'PaymentController@createUserOrder');
    Route::get('/thankyou/{id?}', 'PaymentController@quickReminderOrderRedirect');
    Route::get('/dashboard/thankyou/{id?}', 'PaymentController@userOrderRedirect');

    //Dashboard
    Route::get('/dashboard', 'DashboardController@index');
});


Route::group(['namespace' => 'API', 'prefix' => 'api'], function() {
    Route::group(['middleware' => 'jwt.auth'], function() {

        //Contacts
        Route::get('/contacts/{id?}', 'ContactsController@get');
        Route::post('/contacts', 'ContactsController@insert');
        Route::delete('/contacts/{id}', 'ContactsController@delete');
        Route::put('/contacts', 'ContactsController@update');

        //Reminders
        Route::get('/reminders/upcoming', 'RemindersController@getUpcomingReminders');
        Route::get('/reminders/cancel/{id?}', 'RemindersController@cancelReminder');
        Route::post('/reminders', 'RemindersController@insertReminder');

        //User
        Route::get('/user', 'UserController@getUserDetails');
    });

    //Quick Reminders
    //Route::post('/quickreminders', 'QuickRemindersController@insertQuickReminder');

    //Auth
    Route::post('/login', 'AuthenticateController@authenticate');
    Route::post('/register', 'AuthenticateController@register');

    //test
    Route::get('/test', 'ContactsController@test');
});
