<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('Apitoken')->prefix('v1')->group(function(){
    
    // REGISTRATION
    Route::post('/user/register', 'API\AppuserController@customer_register');
    Route::post('/hotel/register', 'API\AppuserController@hotel_register');

    // EDIT CUSTOMER PROFILE
    Route::post('/user/editprofile', 'API\AppuserController@edit_customer_profile');

    // LOGIN
    Route::post('/login', 'API\loginController@check_login');

    // NEARBY HOTELS WITH DIRECTIONS AND NOTIFICATIONS
    Route::post('/nearbyhotels', 'API\nearbyhotelController@nearbyhotel_notifications');

    // SEARCH HOTEL
    Route::post('/searchhotel', 'API\nearbyhotelController@search_hotels');

    // RESET PASSWORD
    Route::post('/resetpass', 'API\resetpassController@resetpass');

    // EMAIL VERIFICATION
    Route::post('/sendcode', 'API\verificationController@emailverify');
    Route::post('/checkcode', 'API\verificationController@verifycode');

    // MOBILE VERIFICATION
    Route::post('/sendotp', 'API\verificationController@mobileverify');
    Route::post('/checkotp', 'API\verificationController@verifyotp');

    // RATE AND REVIEWS
    Route::post('/storeratings', 'API\RatereviewController@store_ratings');
    Route::post('/showratings', 'API\RatereviewController@show_ratings');

    // LIKED HOTELS BY USER
    Route::post('/likehotel', 'API\LikedhotelsController@like_hotel');
    Route::post('/dislikehotel', 'API\LikedhotelsController@dislike_hotel');
    Route::post('/showlikedhotels', 'API\LikedhotelsController@show_liked_hotels');

    // BOOK A HOTEL
    Route::post('/storebooking', 'API\BookingController@storeBooking');

    // ROOM DETAILS
    Route::post('/roomdetails', 'API\RoomsController@getRoomdetails');
    Route::post('/updatestandardroom', 'API\RoomsController@update_standardRoom');
    Route::post('/updatedeluxeroom', 'API\RoomsController@update_deluxeRoom');
    Route::post('/updatesuperdeluxeroom', 'API\RoomsController@update_superdeluxeRoom');
});


// Route::get('/getimages', 'API\GetimagesController@getImages');
// Route::get('/check', 'API\ApitudeController@check');
