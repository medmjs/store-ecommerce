<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){


//note : thers is prefix admin for all file rout
    Route::group(['prefix'=>'admin','namespace'=>'Dashboard','middleware'=>'auth:admin'],function (){

        Route::get('/','DashboardController@viewDashboard')->name('admin.dashboard');

        Route::group(['prefix'=>'settings'],function (){
            Route::get('shipping-methode/{type}','SittingsController@editShippingMethods')->name('edit.shipping.method');
            Route::put('shipping-methode/{id}','SittingsController@updateShippingMethods')->name('update.shipping.method');

        });

    });


    Route::group(['namespace'=>'Dashboard','middleware'=>'guest:admin','prefix'=>'admin'],function(){
        Route::get('login','LoginController@loginView')->name('admin.login');
        Route::post('login','LoginController@login')->name('admin.post.login');


    });



});


