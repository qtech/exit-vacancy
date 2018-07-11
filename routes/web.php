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

Route::get('/', function () {
    return redirect()->route('viewlogin');
});

Route::get('/login', 'SigninController@view')->name('login');
Route::post('/checklogin', 'SigninController@checkLogin')->name('checklogin');

Route::get('/dashboard', 'DashboardController@view')->name('dashboard');
//Route::post('/excel', 'excelController@excel')->name('excel');
