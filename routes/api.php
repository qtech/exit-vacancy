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
    Route::post('/customer/register', 'API\loginController@customer_register');
    Route::post('/hotel/register', 'API\loginController@hotel_register');

    // LOGIN
    Route::post('/login', 'API\loginController@check_login');

    // NEARBY HOTELS WITH DIRECTIONS
    Route::post('/nearbyhotels', 'API\nearbyhotelController@nearbyhotel_directions');

    // SEARCH HOTEL
    Route::post('/searchhotel', 'API\nearbyhotelController@search_hotels');

    // RESET PASSWORD
    Route::post('/resetpass', 'API\resetpassController@resetpass');

    // EMAIL VERIFICATION
    Route::post('/sendcode', 'API\verificationController@emailverify');
    Route::post('/checkcode', 'API\verificationController@verifycode');

    // RATE AND REVIEWS
    Route::post('/storeratings', 'API\RatereviewController@store_ratings');
});
