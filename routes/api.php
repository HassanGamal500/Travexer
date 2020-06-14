<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Api'], function () {
    // Auth
    Route::post('postlogin', 'AuthController@postlogin');
    Route::post('registration', 'AuthController@registration');
    // Route::post('registrationForGuide', 'AuthController@registrationForGuide');
    // Route::post('registrationForCompany', 'AuthController@registrationForCompany');
    Route::post('verification', 'AuthController@verification');
    // Route::post('verificationForGuide', 'AuthController@verificationForGuide');
    // Route::post('verificationForCompany', 'AuthController@verificationForCompany');

    // Route::group(['middleware' => 'auth:api'], function(){
        Route::post('resend', 'AuthController@resend');
        Route::post('reset_password', 'AuthController@reset_password');
        Route::post('checkVerificationForPassword', 'AuthController@checkVerificationForPassword');
        Route::post('changePassword', 'AuthController@changePassword');
        Route::post('getProfile', 'AuthController@getProfile');
        Route::post('updateProfile', 'AuthController@updateProfile');
        // Route::post('updateProfileForGuide', 'AuthController@updateProfileForGuide');
        // Route::post('updateProfileForCompany', 'AuthController@updateProfileForCompany');
        Route::post('userLogOut', 'AuthController@userLogOut');
        Route::post('setLangUser', 'AuthController@setLangUser');
        Route::post('deleteOption', 'AuthController@deleteOption');

        // App
        Route::post('banners', 'AppController@banners');
        Route::post('listOfCountries', 'AppController@listOfCountries');
        Route::post('listOfCities', 'AppController@listOfCities');
        Route::post('listOfServices', 'AppController@listOfServices');
        Route::post('page', 'AppController@page');
        Route::post('contact_us', 'AppController@contactUs');
        Route::post('notifications', 'AppController@notifications');
        Route::post('listOfNationalities', 'AppController@listOfNationalities');
        Route::post('about_us', 'AppController@aboutUs');
        Route::post('subscribe', 'AppController@subscribe');
        Route::post('home_web', 'AppController@homeWeb');

        // User Flow
        Route::post('all_guides', 'UserFlowGuideController@allGuides');
        Route::post('filter_guides', 'UserFlowGuideController@filterGuides');
        Route::post('guide_details', 'UserFlowGuideController@guideDetails');
        Route::post('book_guide_now', 'UserFlowGuideController@bookGuideNow');
        Route::post('book_guide_later', 'UserFlowGuideController@bookGuideLater');
        Route::post('book_trip_now', 'UserFlowGuideController@bookTripNow');
        Route::post('my_orders_status', 'UserFlowGuideController@myOrderStatus');
        Route::post('order_details', 'UserFlowGuideController@orderDetails');
        Route::post('cancel_order', 'UserFlowGuideController@cancelOrder');
        Route::post('give_review', 'UserFlowGuideController@giveReview');
        Route::post('all_review', 'UserFlowGuideController@allReview');
        Route::post('trips', 'UserFlowGuideController@trips');
        Route::post('filter_trips', 'UserFlowGuideController@filterTrips');
        Route::post('trip_detail', 'UserFlowGuideController@tripDetails');
        Route::post('dolane_detail', 'UserFlowGuideController@dolaneDetails');
        Route::post('broadcasts', 'UserFlowGuideController@broadcasts');
        Route::post('add_broadcast', 'UserFlowGuideController@addBroadcast');
        Route::post('list_of_broadcast_request', 'UserFlowGuideController@listOfRequestBroadcasts');
        Route::post('request_broadcast', 'UserFlowGuideController@requestBroadcast');

        Route::post('categories', 'UserFlowTripController@categories');

        // Guide Flow
        Route::post('add_trip', 'UserFlowTripController@addTrip');
        Route::post('my_books', 'UserFlowTripController@myBooks');
        Route::post('book_details', 'UserFlowTripController@bookDetails');
        Route::post('users_booked', 'UserFlowTripController@userBookedTrip');
        Route::post('accept_reject_book', 'UserFlowTripController@AcceptRejectBook');
        Route::post('start_end_trip', 'UserFlowTripController@startEndTrip');
    // });

});