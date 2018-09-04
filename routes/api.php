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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    // REGISTRATION
    Route::post('/user/register', 'API\AppuserController@customer_register');
    Route::post('/hotel/register', 'API\AppuserController@hotel_register');

    // LOGIN
    Route::post('/login', 'API\loginController@check_login');

    // CHANGE EMAIL
    Route::post('/emailchange', 'API\AppuserController@change_email');

    // CHANGE NUMBER
    Route::post('/numberchange', 'API\AppuserController@change_number');

    // RESET PASSWORD
    Route::post('/resetpass', 'API\resetpassController@resetpass');

    // EMAIL VERIFICATION
    Route::post('/sendcode', 'API\verificationController@emailverify');
    Route::post('/checkcode', 'API\verificationController@verifycode');

    // MOBILE VERIFICATION
    Route::post('/sendotp', 'API\verificationController@mobileverify');
    Route::post('/checkotp', 'API\verificationController@verifyotp');

    // RESEND MOBILE VERIFICATION
    Route::post('/resendotp', 'API\verificationController@resend_mobileverify');
});

// API's WITH LOGIN TOKEN
Route::middleware('Apitoken')->prefix('v1')->group(function(){

    // GET USER PROFILE DETAILS
    Route::post('/userprofiledetails', 'API\AppuserController@get_user_details');

    // GET HOTEL USER PROFILE DETAILS
    Route::post('/hoteluserprofile', 'API\AppuserController@get_hoteluser_details');

    // EDIT CUSTOMER PROFILE
    Route::post('/user/editprofile', 'API\AppuserController@edit_customer_profile');

    // EDIT HOTEL PROFILE
    Route::post('/hotel/editprofile', 'API\AppuserController@edit_hotel_profile');

    // LOGOUT
    Route::post('/logout', 'API\loginController@logout');

    // NEARBY HOTELS WITH DIRECTIONS AND NOTIFICATIONS
    Route::post('/nearbyhotels', 'API\nearbyhotelController@nearbyhotel_notifications');

    // SEARCH HOTEL
    Route::post('/searchhotel', 'API\nearbyhotelController@search_hotels');

    // CHANGE PASSWORD
    Route::post('/changepass', 'API\resetpassController@changepass');

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

    // HOTEL IMAGES
    Route::post('/gethotelimages', 'API\HotelImagesController@get_hotel_images');
    Route::post('/updatehotelimages', 'API\HotelImagesController@update_hotel_images');

    // VISITING AND VISITED GUEST
    Route::post('/visiting', 'API\HotelbookingdetailsController@visiting_guest');
    Route::post('/visited', 'API\HotelbookingdetailsController@visited_guest');

    // HOTEL DETAILS FOR USER (User side)
    Route::post('/hoteldetails', 'API\HotelbookingdetailsController@hotel_details_for_user');

    // USER ARRIVED HOTEL
    Route::post('/uservisited', 'API\BookingController@hotel_is_visited');

    // USER RECENT AND PAST BOOKINGS LIST
    Route::post('/recentbooking', 'API\BookingController@user_recent_booking');
    Route::post('/pastbooking', 'API\BookingController@user_past_booking');

    // ROOM DETAILS
    Route::post('/roomdetails', 'API\RoomsController@getRoomdetails');
    Route::post('/updatekingroom', 'API\RoomsController@update_kingRoom');
    Route::post('/updatequeenroom', 'API\RoomsController@update_queenRoom');

    // HOTEL ACCEPT/DECLINE NOTIFICATIONS
    Route::post('/hotelaccepted', 'API\BookingController@hotel_accepted');
    Route::post('/hoteldeclined', 'API\BookingController@hotel_declined');
    Route::post('/hotelnoresponse', 'API\BookingController@hotel_noresponse');

    // COMMON HOTEL AMENITIES
    Route::get('/amenities', 'API\AmenityController@getAmenities');

    // COMMON ROOM AMENITIES
    Route::get('/roomamenities', 'API\AmenityController@getRoomAmenities');

    // ADD CUSTOM HOTEL AMENITIES
    Route::post('/custom_amenities', 'API\AmenityController@update_custom_amenities');
    Route::post('/get_custom_amenities', 'API\AmenityController@get_custom_amenities');
    
    // QUERY REQUESTS
    Route::post('/query', 'API\QueryController@storequery');

    // STRIPE PAYMENT
    Route::post('/storecard', 'API\PaymentDetailsController@storeCard');
	Route::post('/getcard', 'API\PaymentDetailsController@getCard_details');
	Route::post('/storeupdatepaymentdetails', 'API\PaymentDetailsController@store_update_paymentdetails');
	Route::post('/getpaymentdetails', 'API\PaymentDetailsController@get_paymentdetails');
    Route::post('/splitpayment', 'API\PaymentDetailsController@split_payment_live');
    
    // STORE IMAGES
    Route::post('/storeimages', 'API\CommonImageController@storeImage');

});



