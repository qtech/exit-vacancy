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
        // CHARTS (COMPLETED)
        Route::get('/c.bookings', 'API\ChartbookingsController@all_completed')->name('c.bookings.chart');
        Route::get('/c.t.bookings', 'API\ChartbookingsController@today_completed')->name('c.t.bookings.chart');
        Route::get('/c.w.bookings', 'API\ChartbookingsController@week_completed')->name('c.w.bookings.chart');
        Route::get('/c.m.bookings', 'API\ChartbookingsController@month_completed')->name('c.m.bookings.chart');
        Route::post('/c.d.bookings', 'API\ChartbookingsController@dates_completed')->name('c.d.bookings.chart');

        // CHARTS (PENDING)
        Route::get('/p.bookings', 'API\ChartbookingsController@all_pending')->name('p.bookings.chart');
        Route::get('/p.t.bookings', 'API\ChartbookingsController@today_pending')->name('p.t.bookings.chart');
        Route::get('/p.w.bookings', 'API\ChartbookingsController@week_pending')->name('p.w.bookings.chart');
        Route::get('/p.m.bookings', 'API\ChartbookingsController@month_pending')->name('p.m.bookings.chart');
        Route::post('/p.d.bookings', 'API\ChartbookingsController@dates_pending')->name('p.d.bookings.chart');

        // CHARTS (CANCELLED)
        Route::get('/can.bookings', 'API\ChartbookingsController@all_cancelled')->name('can.bookings.chart');
        Route::get('/can.t.bookings', 'API\ChartbookingsController@today_cancelled')->name('can.t.bookings.chart');
        Route::get('/can.w.bookings', 'API\ChartbookingsController@week_cancelled')->name('can.w.bookings.chart');
        Route::get('/can.m.bookings', 'API\ChartbookingsController@month_cancelled')->name('can.m.bookings.chart');
        Route::post('/can.d.bookings', 'API\ChartbookingsController@dates_cancelled')->name('can.d.bookings.chart');

        Route::prefix('completed')->group(function(){
            Route::get('/bookingexport1', 'ExcelController@completedbookings')->name('e.c.bookings');
            Route::get('/bookingexport2', 'ExcelController@completed_todaybookings')->name('e.c.todaybookings');
            Route::get('/bookingexport3', 'ExcelController@completed_weekbookings')->name('e.c.weekbookings');
            Route::get('/bookingexport4', 'ExcelController@completed_monthbookings')->name('e.c.monthbookings');
            Route::get('/{id?}', 'BookingController@viewbookings_completed')->name('completed.bookings');
        });

        Route::prefix('pending')->group(function(){
            Route::get('/bookingexport5', 'ExcelController@pendingbookings')->name('e.p.bookings');
            Route::get('/bookingexport6', 'ExcelController@pending_todaybookings')->name('e.p.todaybookings');
            Route::get('/bookingexport7', 'ExcelController@pending_weekbookings')->name('e.p.weekbookings');
            Route::get('/bookingexport8', 'ExcelController@pending_monthbookings')->name('e.p.monthbookings');
            Route::get('/{id?}', 'BookingController@viewbookings_pending')->name('pending.bookings');
        });

        Route::prefix('cancelled')->group(function(){
            Route::get('/bookingexport9', 'ExcelController@cancelbookings')->name('e.can.bookings');
            Route::get('/bookingexport10', 'ExcelController@cancel_todaybookings')->name('e.can.todaybookings');
            Route::get('/bookingexport11', 'ExcelController@cancel_weekbookings')->name('e.can.weekbookings');
            Route::get('/bookingexport12', 'ExcelController@cancel_monthbookings')->name('e.can.monthbookings');
            Route::get('/{id?}', 'BookingController@viewbookings_cancelled')->name('cancelled.bookings');
        });
    });

    // APPLICATION USERS
    Route::prefix('appusers')->group(function(){
        Route::post('/userbookingchart', 'API\AppuserController@userbooking_chart')->name('u.bookingchart');
        Route::get('/userexport1', 'ExcelController@getappusers')->name('e.appusers');
        Route::get('/userexport2', 'ExcelController@appusers_nobookings')->name('e.usernobookings');
        Route::get('/userexport3', 'ExcelController@appusers_bookings_this_month')->name('e.userbookingsmonth');
        Route::get('/userexport4', 'ExcelController@appusers_bookingsfiveplus')->name('e.userbookingsfive');
        Route::get('/userexport5', 'ExcelController@appusers_registerthismonth')->name('e.userregister');
        Route::get('/{id?}', 'AppusersController@view_allusers')->name('appusers');
        Route::get('/userbookings/{id}', 'AppusersController@user_bookings')->name('userbookings');
        Route::get('/disableuser/{id}', 'AppusersController@disable')->name('disableuser');
        Route::get('/enableuser/{id}', 'AppusersController@enable')->name('enableuser');
    });

    // HOTEL OWNER
    Route::prefix('hotelowners')->group(function(){
        Route::post('/hotelbookingchart', 'API\AppuserController@hotelbooking_chart')->name('h.bookingchart');
        Route::get('/hoteluserexport', 'ExcelController@gethotelusers')->name('e.hotelusers');
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
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'EmailController@hotel_view')->name('h.mails');
            Route::get('/add', 'EmailController@hotel_add')->name('h.addmail');
            Route::post('/store', 'EmailController@hotel_send')->name('h.storemail');
        });
    });

    // SEND SMS
    Route::prefix('sms')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', 'SMSController@user_view')->name('sms');
            Route::get('/add/{id?}', 'SMSController@user_add')->name('addsms');
            Route::post('/store', 'SMSController@user_send')->name('storesms');
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'SMSController@hotel_view')->name('h.sms');
            Route::get('/add', 'SMSController@hotel_add')->name('h.addsms');
            Route::post('/store', 'SMSController@hotel_send')->name('h.storesms');
        });
    });

    // NOTIFICATIONS
    Route::prefix('notifications')->group(function(){
        Route::prefix('users')->group(function(){
            Route::get('/', 'NotificationController@user_view')->name('notifications');
            Route::get('/add/{id?}', 'NotificationController@user_add')->name('addnotification');
            Route::post('/store', 'NotificationController@user_send')->name('storenotification');
        });

        Route::prefix('hotel')->group(function(){
            Route::get('/', 'NotificationController@hotel_view')->name('h.notifications');
            Route::get('/add', 'NotificationController@hotel_add')->name('h.addnotification');
            Route::post('/store', 'NotificationController@hotel_send')->name('h.storenotification');
        });
    });

    // QUERY REQUESTS
    Route::prefix('queries')->group(function(){
        Route::get('/', 'QueryController@view')->name('query');
    });

    // SETTINGS
    Route::prefix('settings')->group(function(){
        Route::prefix('contactus')->group(function(){
            Route::get('/', 'ContactusController@view')->name('contactus');
            Route::post('/update', 'ContactusController@update')->name('updatecontactus');
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
