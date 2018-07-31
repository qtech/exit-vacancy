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


Route::middleware(['auth','Admin'])->prefix('admin')->group(function(){
    // DASHBOARD
    Route::prefix('dashboard')->group(function(){
        Route::get('/', 'DashboardController@view')->name('dashboard');
    });

    // APPLICATION USERS
    Route::prefix('appusers')->group(function(){
        Route::get('/', 'AppusersController@view')->name('appusers');
    });

    // HOTEL AMENITIES
    Route::prefix('amenities')->group(function(){
        Route::get('/', 'HotelamenityController@view')->name('amenity');
        Route::post('/update', 'AmenityController@add')->name('addamenity');
    });

    // NOTIFICATIONS
    Route::prefix('notifications')->group(function(){
        Route::get('/', 'NotificationController@view')->name('notifications');
        Route::get('/add', 'NotificationController@add')->name('addnotification');
        Route::post('/store', 'NotificationController@store')->name('storenotification');
        Route::get('/delete/{id}', 'NotificationController@delete')->name('deletenotification');
    });
});

Route::middleware(['auth','Hotelowner'])->prefix('Hotelowner')->group(function(){
    // DASHBOARD
    Route::prefix('dashboard')->group(function(){
        Route::get('/', 'DashboardController@view')->name('h.dashboard');
    });

    Route::prefix('hotelprofile')->group(function(){
        Route::get('/', 'Hotel\HotelprofileController@view')->name('hotelprofile');
        Route::post('/update', 'Hotel\HotelprofileController@update')->name('updatehotelprofile');
    });

    Route::prefix('bookings')->group(function(){
        Route::get('/', 'Hotel\HotelbookingController@view')->name('hotelbookings');
        Route::get('/delete/{id}', 'Hotel\HotelbookingController@delete')->name('deletebooking');
    });

    Route::prefix('rooms')->group(function(){
        Route::prefix('king')->group(function(){
            Route::get('/', 'Hotel\AddroomController@add_king_room')->name('h.s.room');
            Route::put('/update', 'Hotel\AddroomController@update_king_room')->name('h.s.update');
            Route::get('/addimage', 'Hotel\AddroomController@add_king_room_images')->name('s.addimages');
        });

        Route::prefix('queen')->group(function(){
            Route::get('/', 'Hotel\AddroomController@add_queen_room')->name('h.d.room');
            Route::put('/update', 'Hotel\AddroomController@update_queen_room')->name('h.d.update');
            Route::get('/addimage', 'Hotel\AddroomController@add_queen_room_images')->name('d.addimages');
        });
    });
});


//Route::post('/excel', 'excelController@excel')->name('excel');
