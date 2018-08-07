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
       
        // CHARTS_DATA
        Route::get('/registrationdata', 'API\DashboardController@chart_all_data')->name('dashboard.chartData');
        Route::get('/bookingdata','API\DashboardController@bookings_data')->name('dashboard.bookingData');
        Route::post('/rdatawithdates', 'API\DashboardController@r_data_with_dates')->name('r.datawithdates');
        Route::post('/bdatawithdates', 'API\DashboardController@b_data_with_dates')->name('b.datawithdates');
    });

    // BOOKING DETAILS
    Route::prefix('bookings')->group(function(){
        // CHARTS DATA
        Route::get('/completebookings', 'API\BookingController@completebookingchart')->name('completebookings.chart');
        Route::get('/cancelbookings', 'API\BookingController@cancelbookingchart')->name('cancelbookings.chart');

        Route::prefix('completed')->group(function(){
            Route::get('/{id?}', 'BookingController@viewbookings_completed')->name('completed.bookings');
        });

        Route::prefix('cancelled')->group(function(){
            Route::get('/{id?}', 'BookingController@viewbookings_cancelled')->name('cancelled.bookings');
        });
    });

    // APPLICATION USERS
    Route::prefix('appusers')->group(function(){
        Route::get('/export', 'ExcelController@getappusers')->name('exceldemo');
        Route::get('/{id?}', 'AppusersController@view_allusers')->name('appusers');
        Route::get('/userbookings/{id}', 'AppusersController@user_bookings')->name('userbookings');
        Route::get('/disableuser/{id}', 'AppusersController@disable')->name('disableuser');
        Route::get('/enableuser/{id}', 'AppusersController@enable')->name('enableuser');

    });

    // HOTEL OWNER
    Route::prefix('hotelowners')->group(function(){
        Route::get('/', 'HotelusersController@view')->name('hotelusers');
        Route::get('/details/{id}', 'HotelusersController@hotel_user_details')->name('hoteldetails');
    });

    // HOTEL AMENITIES
    Route::prefix('amenities')->group(function(){
        Route::get('/getamenities', 'AmenityController@getData')->name('getamenities'); //AJAX GET DATA
        Route::get('/', 'AmenityController@view')->name('amenity');
        Route::post('/update', 'AmenityController@add')->name('addamenity');
        Route::post('/disable', 'AmenityController@disable')->name('disableamenity');
    });

    // SEND MAILS
    Route::prefix('mails')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', 'EmailController@user_view')->name('mails');
            Route::get('/add/{id?}', 'EmailController@user_add')->name('addmail');
            Route::post('/store', 'EmailController@user_send')->name('storemail');
            Route::get('/delete/{id}', 'EmailController@user_delete')->name('deletemail');
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'EmailController@hotel_view')->name('h.mails');
            Route::get('/add', 'EmailController@hotel_add')->name('h.addmail');
            Route::post('/store', 'EmailController@hotel_send')->name('h.storemail');
            Route::get('/delete/{id}', 'EmailController@hotel_delete')->name('h.deletemail');
        });
    });

    // SEND SMS
    Route::prefix('sms')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', 'SMSController@user_view')->name('sms');
            Route::get('/add/{id?}', 'SMSController@user_add')->name('addsms');
            Route::post('/store', 'SMSController@user_send')->name('storesms');
            Route::get('/delete/{id}', 'SMSController@user_delete')->name('deletesms');
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'SMSController@hotel_view')->name('h.sms');
            Route::get('/add', 'SMSController@hotel_add')->name('h.addsms');
            Route::post('/store', 'SMSController@hotel_send')->name('h.storesms');
            Route::get('/delete/{id}', 'SMSController@hotel_delete')->name('h.deletesms');
        });
    });

    // NOTIFICATIONS
    Route::prefix('notifications')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', 'NotificationController@user_view')->name('notifications');
            Route::get('/add/{id?}', 'NotificationController@user_add')->name('addnotification');
            Route::post('/store', 'NotificationController@user_send')->name('storenotification');
            Route::get('/delete/{id}', 'NotificationController@user_delete')->name('deletenotification');
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'NotificationController@hotel_view')->name('h.notifications');
            Route::get('/add', 'NotificationController@hotel_add')->name('h.addnotification');
            Route::post('/store', 'NotificationController@hotel_send')->name('h.storenotification');
            Route::get('/delete/{id}', 'NotificationController@hotel_delete')->name('h.deletenotification');
        });
    });
});

Route::middleware(['auth','Hotelowner'])->prefix('Hotelowner')->group(function(){
    // DASHBOARD
    Route::prefix('dashboard')->group(function(){
        Route::get('/', 'DashboardController@viewhoteldashboard')->name('h.dashboard');        
        // CHARTS DATA
        Route::get('/chartdata', 'API\DashboardController@hotel_bookings_data')->name('hotelbooking.chart');
        Route::post('/datawithdates', 'API\DashboardController@h_data_with_dates')->name('hbooking.chart.dates');
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
            Route::post('/update', 'Hotel\AddroomController@update_king_room')->name('h.s.update');
            Route::get('/addimage', 'Hotel\AddroomController@add_king_room_images')->name('s.addimages');
        });

        Route::prefix('queen')->group(function(){
            Route::get('/', 'Hotel\AddroomController@add_queen_room')->name('h.d.room');
            Route::post('/update', 'Hotel\AddroomController@update_queen_room')->name('h.d.update');
            Route::get('/addimage', 'Hotel\AddroomController@add_queen_room_images')->name('d.addimages');
        });
    });
});


//Route::post('/excel', 'excelController@excel')->name('excel');
