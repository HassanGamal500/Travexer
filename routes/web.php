<?php

use Illuminate\Support\Facades\Route;

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

use Illuminate\Support\Facades\App;

Route::get('admin/lang/{locale}', function ($locale){
    App::setLocale($locale);
    session()->put('back-locale', $locale);
    return redirect()->back();
});

//--------------------------------------------

// Test For Database 
// Route::get('/insert', 'Api\SettingController@city');
//---------------------

//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Cache Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

//Clear Config cache:
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});

//---------------------------------------
Route::get('/', function (){
    return view('welcome');
});

Route::get('/permission', function(){
    return view('admin.access');
});

Route::get('/admin/preLogin', 'Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/preLogin', 'Admin\AdminLoginController@login')->name('admin.login.post');
Route::get('/admin/preLogout', 'Admin\AdminLoginController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => ['admin', 'back_language']], function (){
    // AJAX 
    Route::post('/changeStatus', 'AdminUserController@changeStatus');
    // Route::post('/getToken', 'AdministrationController@getToken')->name('getToken');
    // Route::get('/getType', 'AdministrationController@type')->name('getType');
    Route::post('/get_city', 'AdminCityController@getCity');
    //Dashboard
    Route::get('/', 'AdminDashboardController@index')->name('dashboard');
    // Users
    Route::get('/users', 'AdminUserController@index')->name('all_users');
    Route::get('/add_user', 'AdminUserController@create')->name('add_user');
    Route::post('/add_user', 'AdminUserController@store')->name('store_user');
    Route::get('/edit_user/{id}', 'AdminUserController@edit')->name('edit_user');
    Route::post('/edit_user/{id}', 'AdminUserController@update')->name('update_user');
    Route::delete('/delete_user/{id}', 'AdminUserController@destroy')->name('delete_user');
    // Guides
    Route::get('/guides', 'AdminGuideController@index')->name('all_guides');
    Route::get('/add_guide', 'AdminGuideController@create')->name('add_guide');
    Route::post('/add_guide', 'AdminGuideController@store')->name('store_guide');
    Route::get('/edit_guide/{id}', 'AdminGuideController@edit')->name('edit_guide');
    Route::post('/edit_guide/{id}', 'AdminGuideController@update')->name('update_guide');
    Route::delete('/delete_guide/{id}', 'AdminGuideController@destroy')->name('delete_guide');
    // Companies
    Route::get('/companies', 'AdminCompanyController@index')->name('all_companies');
    Route::get('/add_company', 'AdminCompanyController@create')->name('add_company');
    Route::post('/add_company', 'AdminCompanyController@store')->name('store_company');
    Route::get('/edit_company/{id}', 'AdminCompanyController@edit')->name('edit_company');
    Route::post('/edit_company/{id}', 'AdminCompanyController@update')->name('update_company');
    Route::delete('/delete_company/{id}', 'AdminCompanyController@destroy')->name('delete_company');
    // Advertisements
    Route::get('advertisements', 'AdminBannerController@index');
    Route::get('/add_advertisement', 'AdminBannerController@create')->name('add_advertisement');
    Route::post('/add_advertisement', 'AdminBannerController@store')->name('store_advertisement');
    Route::get('/edit_advertisement/{id}', 'AdminBannerController@edit')->name('edit_advertisement');
    Route::post('/edit_advertisement/{id}', 'AdminBannerController@update')->name('update_advertisement');
    Route::delete('/delete_advertisement/{id}', 'AdminBannerController@destroy')->name('delete_advertisement');
    // Pages
    Route::get('pages', 'AdminPageController@index');
    Route::get('/edit/{id}', 'AdminPageController@edit')->name('edit_page');
    Route::post('/update_page/{id}', 'AdminPageController@update')->name('update_page');
    // Notification
    Route::get('notifications', 'AdminNotificationController@index');
    Route::get('/add_notification', 'AdminNotificationController@create')->name('add_notification');
    Route::post('/add_notification', 'AdminNotificationController@store')->name('store_notification');
    Route::delete('/delete_notification/{id}', 'AdminNotificationController@destroy')->name('delete_notification');
    // Admin Controll
    Route::get('/edit_profile/{id}', 'AdminLoginController@editProfile')->name('edit_profile');
    Route::post('/edit_profile/{id}', 'AdminLoginController@updateProfile')->name('update_profile');
    // contact us 
    Route::get('contact_web', 'AdminContactController@indexWeb');
    Route::get('contact_phone', 'AdminContactController@indexPhone');
    // Route::post('contact_notify', 'ContactController@contact_notify')->name('contact_notify');
    // Route::get('get_contact', 'ContactController@getContacts')->name('contact_count');
    Route::delete('delete_contact/{id}', 'AdminContactController@destroy')->name('delete_contact');
    // rates
    Route::get('guide_rates', 'AdminRateController@guideRate');
    Route::get('trip_rates', 'AdminRateController@TripRate');
    Route::delete('delete_rate/{id}', 'AdminRateController@destroy')->name('delete_rate');
    // Countries
    Route::get('countries', 'AdminCountryController@index');
    Route::get('/add_country', 'AdminCountryController@create')->name('add_country');
    Route::post('/add_country', 'AdminCountryController@store')->name('store_country');
    Route::get('/edit_country/{id}', 'AdminCountryController@edit')->name('edit_country');
    Route::post('/edit_country/{id}', 'AdminCountryController@update')->name('update_country');
    Route::delete('/delete_country/{id}', 'AdminCountryController@destroy')->name('delete_country');
    // Cities
    Route::get('cities', 'AdminCityController@index');
    Route::get('/add_city', 'AdminCityController@create')->name('add_city');
    Route::post('/add_city', 'AdminCityController@store')->name('store_city');
    Route::get('/edit_city/{id}', 'AdminCityController@edit')->name('edit_city');
    Route::post('/edit_city/{id}', 'AdminCityController@update')->name('update_city');
    Route::delete('/delete_city/{id}', 'AdminCityController@destroy')->name('delete_city');
    // Nationalities
    Route::get('nationalities', 'AdminNationalityController@index');
    Route::get('/add_nationality', 'AdminNationalityController@create')->name('add_nationality');
    Route::post('/add_nationality', 'AdminNationalityController@store')->name('store_nationality');
    Route::get('/edit_nationality/{id}', 'AdminNationalityController@edit')->name('edit_nationality');
    Route::post('/edit_nationality/{id}', 'AdminNationalityController@update')->name('update_nationality');
    Route::delete('/delete_nationality/{id}', 'AdminNationalityController@destroy')->name('delete_nationality');
    // Services
    Route::get('services', 'AdminServiceController@index');
    Route::get('/add_service', 'AdminServiceController@create')->name('add_service');
    Route::post('/add_service', 'AdminServiceController@store')->name('store_service');
    Route::get('/edit_service/{id}', 'AdminServiceController@edit')->name('edit_service');
    Route::post('/edit_service/{id}', 'AdminServiceController@update')->name('update_service');
    Route::delete('/delete_service/{id}', 'AdminServiceController@destroy')->name('delete_service');
    // Dolane
    Route::get('/dolane', 'AdminDolaneController@edit')->name('edit_dolane');
    Route::post('/edit_service', 'AdminDolaneController@update')->name('update_dolane');
    // Dolane Images
    Route::get('dolane_images', 'AdminDolaneImageController@index');
    Route::get('/add_dolane_image', 'AdminDolaneImageController@create')->name('add_dolane_image');
    Route::post('/add_dolane_image', 'AdminDolaneImageController@store')->name('store_dolane_image');
    Route::get('/edit_dolane_image/{id}', 'AdminDolaneImageController@edit')->name('edit_dolane_image');
    Route::post('/edit_dolane_image/{id}', 'AdminDolaneImageController@update')->name('update_dolane_image');
    Route::delete('/delete_dolane_image/{id}', 'AdminDolaneImageController@destroy')->name('delete_dolane_image');
    // Faqs
    Route::get('faqs', 'AdminFaqController@index');
    Route::get('/add_faq', 'AdminFaqController@create')->name('add_faq');
    Route::post('/add_faq', 'AdminFaqController@store')->name('store_faq');
    Route::get('/edit_faq/{id}', 'AdminFaqController@edit')->name('edit_faq');
    Route::post('/edit_faq/{id}', 'AdminFaqController@update')->name('update_faq');
    Route::delete('/delete_faq/{id}', 'AdminFaqController@destroy')->name('delete_faq');
    // About Us
    Route::get('about', 'AdminAboutUsController@edit')->name('edit_about');
    Route::post('update_about', 'AdminAboutUsController@update')->name('update_about');
    // Screen Shots
    Route::get('screen_shot', 'AdminScreenController@index');
    Route::get('/add_screen_shot', 'AdminScreenController@create')->name('add_screen_shot');
    Route::post('/add_screen_shot', 'AdminScreenController@store')->name('store_screen_shot');
    Route::get('/edit_screen_shot/{id}', 'AdminScreenController@edit')->name('edit_screen_shot');
    Route::post('/edit_screen_shot/{id}', 'AdminScreenController@update')->name('update_screen_shot');
    Route::delete('/delete_screen_shot/{id}', 'AdminScreenController@destroy')->name('delete_screen_shot');
    // Broadcast
    Route::get('broadcasts', 'AdminBroadcastController@index');
    Route::get('broadcasts/{id}', 'AdminBroadcastController@get_broadcast_user')->name('broadcast_user');
    Route::post('get_broadcast', 'AdminBroadcastController@get_broadcast')->name('get_broadcast');
    // Trip
    Route::get('trips', 'AdminTripController@index');
    Route::get('edit_trip/{id}', 'AdminTripController@edit')->name('edit_trip');
    Route::post('edit_trip/{id}', 'AdminTripController@update')->name('update_trip');
    // Trip Info
    Route::get('info/{id}', 'AdminTripInfoController@index')->name('info');
    Route::get('edit_info/{id}', 'AdminTripInfoController@edit')->name('edit_info');
    Route::post('edit_info/{id}', 'AdminTripInfoController@update')->name('update_info');
    // Order 
    Route::get('order_guide', 'AdminOrderController@indexGuide');
    Route::get('order_trip', 'AdminOrderController@indexTrip');
    Route::get('order_guide/{id}', 'AdminOrderController@get_order_guide_user')->name('order_guide');
    Route::get('order_trip/{id}', 'AdminOrderController@get_order_trip_user')->name('order_trip');
    Route::get('order_detail/{id}', 'AdminOrderController@orderDetail')->name('order_detail');
    // Administration
    Route::get('/administrations', 'AdminAdministrationController@index');
    Route::get('/add_administration', 'AdminAdministrationController@create')->name('add_administration');
    Route::post('/add_administration', 'AdminAdministrationController@store')->name('store_administration');
    Route::get('/edit_administration/{id}', 'AdminAdministrationController@edit')->name('edit_administration');
    Route::post('/edit_administration/{id}', 'AdminAdministrationController@update')->name('update_administration');
    Route::delete('/delete_administration/{id}', 'AdminAdministrationController@destroy')->name('delete_administration');
    // Subscribes
    Route::get('subscribes', 'AdminSubscribeController@index');
    Route::delete('delete_subscribe/{id}', 'AdminSubscribeController@destroy')->name('delete_subscribe');
    // Cron Job 
    // Route::get('/crons', 'CronJobController@cron')->name('cron_job');
});

// Route::get('/', function () {
//     return view('admin/dashboard/index');
// });


// Route::get('users', function () {
//     return view('admin/users/index');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
