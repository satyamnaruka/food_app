<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PreLoginController;
use App\Http\Controllers\API\PostLoginController;

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

Route::group([
    'middleware' => 'auth:api'
  ], function() {
    Route::post("change-password","API\PostLoginController@changePassword");
    Route::get("user-profile","API\PostLoginController@userProfile");
    Route::post("add-address","API\PostLoginController@addAddress");
    Route::post("update-profile","API\PostLoginController@updateProfile");
    Route::get("logout","API\PostLoginController@logout");
    Route::post('forgot-password',"API\preLoginController@forgotPassword");
    Route::post('add-to-cart',"API\PostLoginController@addToCart");
  });
  

Route::get('get-product-list/{id}',"API\PostLoginController@getProductByCate");
Route::get('product-list',"API\PostLoginController@productList");
Route::get('category-list',"API\PostLoginController@categoryList");
Route::post('email-user-registration', [preLoginController::class, 'emailRegistration']);
Route::post('service-registration', [preLoginController::class, 'serviceRegistration']);
Route::post('mobile-get-otp', [preLoginController::class, 'sendOtpOnMobile']);
Route::post('mobile-user-registration', [preLoginController::class, 'mobileRegistration']);
Route::post('mobile-get-otp', [preLoginController::class, 'sendOtpOnMobile']);
Route::post('validate-otp', [preLoginController::class, 'validateOtp']);
Route::post('login', [preLoginController::class, 'login']);