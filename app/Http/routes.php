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
    Route::auth();
    
    //Homepage
    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/home/pricing', 'HomeController@pricing');
    Route::get('/home/faq', 'HomeController@faq');
    
    //Dashboard
    Route::get('/dashboard', 'DashboardController@index');
    Route::get('/dashboard/contacts', 'DashboardController@contacts');
    Route::post('/dashboard/contacts', 'DashboardController@contacts');
    
    //API
    //Contacts
    Route::get('api/contacts/{id?}', 'API\ContactsController@get');
    Route::post('api/contacts', 'API\ContactsController@insert');
    Route::delete('api/contacts/{id?}', 'API\ContactsController@delete');
});
