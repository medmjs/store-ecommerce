<?php

use Illuminate\Support\Facades\Route;

/*
  |--------------------------------------------------------------------------
  | Site Routes
  |--------------------------------------------------------------------composer------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
        ], function() {
    
    
    Route::group(['namespace' => 'Site','middleware'=>'web'], function() {
        Route::get('/','HomeController@home')->name('home') -> middleware('verifiedUser');
   
    });
    
    
    
    
    

    Route::group(['namespace' => 'Site', 'middleware' => ['auth', 'verifiedUser']], function() {//must be verify
        Route::get('profile', function() {
            return "you are auth";
        })->name('profile');
    });
    
    
    

    Route::group(['namespace' => 'Auth', 'middleware' => 'auth'], function() {

        Route::post('verifyUser', 'VerificationCodeController@verifyCode')->name('verifyCode');

        Route::get('verify', 'VerificationCodeController@verify')->name('verify');
    });
    
    
    
    
    
    

});
