<?php

use Illuminate\Support\Facades\Route;

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

Route::get('login', function () {
    return 'user page login';
})->name('login');


Route::get('test', function () {
    $cat = App\Models\Category::find(1);
    $cat->makeVisible(['translations']);

    return $cat;
})->name('test');
