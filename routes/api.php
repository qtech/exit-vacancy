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

    // LOGIN AND LOGOUT
    Route::post('/login', 'API\loginController@check_login');
    Route::post('/logout', 'API\loginController@logout');

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

    // HOTEL BOOKING DETAILS
    Route::post('/hotelbookingdetails', 'API\HotelbookingdetailsController@bookingdetails_hotel');

    // VISITING AND VISITED GUEST
    Route::post('/visiting', 'API\HotelbookingdetailsController@visiting_guest');
    Route::post('/visited', 'API\HotelbookingdetailsController@visited_guest');

    // HOTEL DETAILS FOR USER (User side)
    Route::post('/hoteldetails', 'API\HotelbookingdetailsController@hotel_details_for_user');

    // USER ARRIVED HOTEL
    Route::post('/uservisited', 'API\BookingController@hotel_is_visited');

    // ROOM DETAILS
    Route::post('/roomdetails', 'API\RoomsController@getRoomdetails');
    Route::post('/updatekingroom', 'API\RoomsController@update_kingRoom');
    Route::post('/updatequeenroom', 'API\RoomsController@update_queenRoom');

    // HOTEL ACCEPT/DECLINE NOTIFICATIONS
    Route::post('/hotelaccepted', 'API\BookingController@hotel_accepted');
    Route::post('/hoteldeclined', 'API\BookingController@hotel_declined');
    Route::post('/hotelnoresponse', 'API\BookingController@hotel_noresponse');
});


// Route::get('/getimages', 'API\GetimagesController@getImages');
// Route::get('/check', 'API\ApitudeController@check');
