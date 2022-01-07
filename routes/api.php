<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User_controller;
use App\Http\Controllers\Admin_controller;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register_user', [User_controller::class, 'register_user'])->name('register_user');
Route::post('check_login_user', [User_controller::class, 'check_login_user'])->name('check_login_user');
Route::post('update_user', [User_controller::class, 'update_user'])->name('update_user');
Route::get('check_existing_mobile_user', [User_controller::class, 'check_existing_mobile_user'])->name('check_existing_mobile_user');
Route::get('get_user_schedule', [User_controller::class, 'get_user_schedule'])->name('get_user_schedule');
Route::get('cancel_appointment', [User_controller::class, 'cancel_appointment'])->name('cancel_appointment');
Route::get('get_upcoming_visit', [User_controller::class, 'get_upcoming_visit'])->name('get_upcoming_visit');
Route::post('send_forgot_otp', [User_controller::class, 'send_forgot_otp'])->name('send_forgot_otp');
Route::post('update_user_password', [User_controller::class, 'update_user_password'])->name('update_user_password');
Route::post('send_otp_for_mobile_verify', [User_controller::class, 'send_otp_for_mobile_verify'])->name('send_otp_for_mobile_verify');

Route::get('get_all_appliance', [User_controller::class, 'get_all_appliance'])->name('get_all_appliance');


//Service-request 
Route::post('submit_service_request', [User_controller::class, 'submit_service_request'])->name('submit_service_request');
Route::get('cancel_request', [User_controller::class, 'cancel_request'])->name('cancel_request');

//installation Request
Route::post('submit_installation_request', [User_controller::class, 'submit_installation_request'])->name('submit_installation_request');

//Warren Request
Route::post('submit_warrenty_request', [User_controller::class, 'submit_warrenty_request'])->name('submit_warrenty_request');

//Accessory Request
Route::post('place_accessory_order', [User_controller::class, 'place_accessory_order'])->name('place_accessory_order');

//Feedback
Route::post('submit_app_feedback', [User_controller::class, 'submit_app_feedback'])->name('submit_app_feedback');

//Schedule
Route::get('get_user_service', [User_controller::class, 'get_user_service'])->name('get_user_service');

//Rating
Route::post('technician_rating', [User_controller::class, 'technician_rating'])->name('technician_rating');

//Resell Product
Route::get('get_resell_product', [User_controller::class, 'get_resell_product'])->name('get_resell_product');
Route::get('place_resell_order', [User_controller::class, 'place_resell_order'])->name('place_resell_order');
Route::get('get_all_resell_product', [User_controller::class, 'get_all_resell_product'])->name('get_all_resell_product');


//admin API
Route::get('get_count', [User_controller::class, 'get_count'])->name('get_count');

//resell request
Route::get('get_resell_request_list', [Admin_controller::class, 'get_resell_order_api'])->name('get_resell_request_list');
Route::get('change_product_status', [Admin_controller::class, 'change_status'])->name('change_product_status');

//Service Request
Route::get('get_service_request_list', [Admin_controller::class, 'get_service_request_api'])->name('get_service_request_list');

//Installaition Request
Route::get('get_installation_request_list', [Admin_controller::class, 'get_installation_request_api'])->name('get_installation_request_list');

//Accessory Request
Route::get('get_accessory_request_list', [Admin_controller::class, 'get_accessory_req_api'])->name('get_accessory_request_list');

//Extend Warranty Request

Route::get('get_extend_warranty_request_list', [Admin_controller::class, 'get_extend_warrenty_api'])->name('get_extend_warranty_request_list');

