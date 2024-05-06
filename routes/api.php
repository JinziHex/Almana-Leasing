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
Route::get('test-reservation','Api\CustomerController@testreserve');
Route::post('test-payment','Api\CustomerController@testPayment');
Route::get('connectsms-test','Api\CustomerController@testsms');
Route::post('customer/index','Api\CustomerController@index');
//customer-login verify
Route::post('customer/login','Api\CustomerController@login');
//customer-registration
Route::post('customer/create','Api\CustomerController@create');
//customer otpcheck 
Route::get('customer/otp-verify','Api\CustomerController@verify_otp');
//change password
Route::get('customer/change-password','Api\CustomerController@change_password')->middleware('auth:api');
//resent otp
Route::get('customer/resent-otp','Api\CustomerController@resentOtp');

//currency List
Route::get('currency/list','Api\CurrencyController@list')->middleware('auth:api');
//category list
Route::get('category/list','Api\CategoryController@list')->middleware('auth:api');
Route::get('web/category/list','Api\CategoryController@webcategorylist');
//maker list
Route::get('maker/list','Api\CategoryController@makerList')->middleware('auth:api');

Route::get('category/show','Api\CategoryController@show')->middleware('auth:api');
//city list
Route::get('city/list','Api\CityController@show')->middleware('auth:api');
Route::get('web-city/list','Api\CityController@webCityList');
//locations list
Route::get('location/list','Api\LocationController@show')->middleware('auth:api');
Route::get('web-location/list','Api\LocationController@webLocationList');
Route::get('fetch/city/location','Api\LocationController@getLocation')->middleware('auth:api');
Route::get('fetch/city/location-web','Api\LocationController@getLocationBasedOnCityWEb');
//search cars 
Route::get('item/search','Api\SearchController@search')->middleware('auth:api');
Route::get('item/search-web','Api\SearchController@webCarList');
//coupon
Route::get('coupons/listing','Api\SearchController@getAvailableCoupons')->middleware('auth:api');
Route::post('coupons/apply','Api\SearchController@applyCoupon')->middleware('auth:api');
Route::post('coupons/remove','Api\SearchController@removeCoupon')->middleware('auth:api');
//feedback
Route::post('user/feedback','Api\FeedbackController@save')->middleware('auth:api');
//booking
Route::get('customer/info','Api\BookingController@get_info')->middleware('auth:api');
Route::post('user/booking','Api\BookingController@save')->middleware('auth:api');
Route::post('user/booking-update','Api\BookingController@update')->middleware('auth:api');
Route::get('booking-success','Api\BookingController@bookingSuccess')->middleware('auth:api');
Route::get('payment-cancel','Api\BookingController@paymentCancel')->middleware('auth:api');

//profile data update 
Route::get('user/profile-update-info','Api\ProfileController@getUpdateInfo')->middleware('auth:api');
Route::post('user/profile/update','Api\ProfileController@user_info_update')->middleware('auth:api');
//rent History
Route::get('user/rent/history','Api\RentController@rentHistory')->middleware('auth:api');
//change password
Route::get('user/change/password','Api\ProfileController@password_change')->middleware('auth:api');
//reservations
Route::get('user/reservations','Api\ReservationController@getReservations')->middleware('auth:api');
//country list 
Route::get('country/list','Api\CountryController@listCountry');
//check mobile number existence
Route::get('check/mobile','Api\CustomerController@checkMobile');
//logout 
Route::get('customer/logout','Api\ProfileController@logoutApi')->middleware('auth:api');
//Customer Profile delete
Route::get('customer/delete','Api\ProfileController@Customerdeactivate')->middleware('auth:api');

//forgot-password mobile verification
Route::get('user/mobile-verify','Api\PasswordController@verifyMobile');
Route::get('user/forgot-password/otp-verify','Api\PasswordController@verifyOtp');
Route::get('user/reset-password','Api\PasswordController@resetPassword');


//notifications
Route::get('customer/notifications','Api\NotificationController@listNotifications')->middleware('auth:api');
Route::post('customer/notification/update','Api\NotificationController@updateStatus')->middleware('auth:api');

//booking cancellation
Route::post('customer/booking-cancel','Api\BookingController@cancelBooking')->middleware('auth:api');


//book again get info
Route::get('customer/book-again/get-info','Api\BookingController@bookAgainInfo')->middleware('auth:api');


//view booking
Route::get('customer/view/booking','Api\BookingController@ViewEachBook');

Route::get('terms-conditions','Api\BookingController@termsConditions')->middleware('auth:api');
Route::get('additional-information','Api\BookingController@additionaInfo')->middleware('auth:api');
Route::get('list-ads','Api\SearchController@listAds')->middleware('auth:api');


//React web





Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});
