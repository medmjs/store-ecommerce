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
        Route::get('logout','LoginController@logout')->name('admin.logout');

        Route::group(['prefix'=>'settings'],function (){
            Route::get('shipping-methode/{type}','SittingsController@editShippingMethods')->name('edit.shipping.method');
            Route::put('shipping-methode/{id}','SittingsController@updateShippingMethods')->name('update.shipping.method');

        });//end route settings

        Route::group(['prefix'=>'profile'],function (){

            Route::get('profile','ProfileController@editProfile')->name('admin.profile');
            Route::put('updateprofile','ProfileController@updateProfile')->name('update.admin.profile');

        });//end route profile

        ########################### begin Categories #############################

        Route::group(['prefix'=>'categories'],function(){

            Route::get('/','mainCatigoriesController@index')->name('admin.mainCategories');
            Route::get('create','mainCatigoriesController@create')->name('admin.mainCategories.create');
            Route::post('store','mainCatigoriesController@store')->name('admin.mainCategories.store');
            Route::get('edit/{id}','mainCatigoriesController@edit')->name('admin.maincategories.edit');
            Route::post('update/{id}','mainCatigoriesController@update')->name('admin.maincategories.update');
            Route::get('delete/{id}','mainCatigoriesController@delete')->name('admin.maincategories.delete');
            Route::get('changeStatus/{id}','mainCatigoriesController@delete')->name('admin.maincategories.changeStatus');


        });


        ########################### End Categories ###############################
        ########################### begin SubCategories ###############################
        Route::group(['prefix'=>'subCategories'],function(){

            Route::get('/','SubCatigoriesController@index')->name('admin.subCatigories');
            Route::get('create','SubCatigoriesController@create')->name('admin.subCatigories.create');
            Route::post('store','SubCatigoriesController@store')->name('admin.subCatigories.store');
            Route::get('edit/{id}','SubCatigoriesController@edit')->name('admin.subCatigories.edit');
            Route::post('update/{id}','SubCatigoriesController@update')->name('admin.subCatigories.update');
            Route::get('delete/{id}','SubCatigoriesController@delete')->name('admin.subCatigories.delete');
            Route::get('changeStatus/{id}','SubCatigoriesController@delete')->name('admin.subCatigories.changeStatus');


        });

        ########################### End SubCategories ###############################


        ########################### begin Brand ###############################
        Route::group(['prefix'=>'brands'],function(){

            Route::get('/','BrandsController@index')->name('admin.brands');
            Route::get('create','BrandsController@create')->name('admin.brands.create');
            Route::post('store','BrandsController@store')->name('admin.brands.store');
            Route::get('edit/{id}','BrandsController@edit')->name('admin.brands.edit');
            Route::post('update/{id}','BrandsController@update')->name('admin.brands.update');
            Route::get('delete/{id}','BrandsController@delete')->name('admin.brands.delete');
            Route::get('changeStatus/{id}','BrandsController@delete')->name('admin.brands.changeStatus');


        });

        ########################### End brand ###############################



    });


    Route::group(['namespace'=>'Dashboard','middleware'=>'guest:admin','prefix'=>'admin'],function(){
        Route::get('login','LoginController@loginView')->name('admin.login');
        Route::post('login','LoginController@login')->name('admin.post.login');


    });


});


