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
    return redirect()->route('login');
});

// LOGIN
Route::get('/login', 'SigninController@view')->name('login');
Route::post('/checklogin', 'SigninController@checkLogin')->name('checklogin');
Route::get('/logout', 'SigninController@logout')->name('logout');


Route::middleware('auth')->prefix('admin')->group(function(){
    // DASHBOARD
    Route::prefix('dashboard')->group(function(){
        Route::get('/', 'DashboardController@view')->name('dashboard');
    });

    // APPLICATION USERS
    Route::prefix('appusers')->group(function(){
        Route::get('/', 'AppusersController@view')->name('appusers');
    });

    // NOTIFICATIONS
    Route::prefix('notifications')->group(function(){
        Route::get('/', 'NotificationController@view')->name('notifications');
        Route::get('/add', 'NotificationController@add')->name('addnotification');
        Route::post('/store', 'NotificationController@store')->name('storenotification');
        Route::get('/delete/{id}', 'NotificationController@delete')->name('deletenotification');
    });
});



//Route::post('/excel', 'excelController@excel')->name('excel');
