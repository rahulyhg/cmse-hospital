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

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::group(['middleware' => 'auth'],function() {

        Route::get('/', function () {
            return view('welcome');
        });

        Route::get('orders/newrequest', 'OrderController@newrequest');
        Route::resource('orders','OrderController');

        Route::get('orders/{id}/cancel', 'OrderController@cancel');
        Route::get('orders/{id}/rerequest', 'OrderController@rerequest');
        Route::get('orders/{id}/receive', 'OrderController@receive');


        //CART
        Route::post('cart/add','CartController@add');
        Route::get('cart/remove/{id}',['as' => 'removeCart', 'uses' => 'CartController@remove']);
        Route::get('cart/show', 'CartController@show');

        //CART USAGE
        Route::post('cart/addusage', 'CartController@addusage');
        Route::get('cart/removeusage/{id}',['as' => 'removeusageCart', 'uses' => 'CartController@removeusage']);
        Route::get('cart/showusage', 'CartController@showusage');

        //ITEMS
        Route::get('items', 'ItemController@index');
        Route::get('items/{id}', 'ItemController@show');
        Route::get('items/{id}/adjustment', ['as' => 'items.adjustment','uses' => 'ItemAdjustmentController@create']);
        Route::post('items/adjustment', ['as' => 'items.adjustment','uses' => 'ItemAdjustmentController@store']);

        //USAGES
        Route::get('usages/newusage', 'UsageController@newusage');
        Route::resource('usages', 'UsageController');


    });
});
