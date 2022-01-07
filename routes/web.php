<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin_controller;
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




Route::get('check_login', [Admin_controller::class, 'check_login'])->name('check_login');
Route::view('log_in', 'log_in')->name('log_in');

Route::group(['middleware' => ['Session_check']], function () {

Route::get('/', [Admin_controller::class, 'dashboard'])->name('dashboard');
Route::view('app_user', 'app_user')->name('app_user');
Route::get('disable_user', [Admin_controller::class, 'disable_user'])->name('disable_user');
Route::view('service_request', 'service_request')->name('service_request');
Route::view('installation_request', 'installation_request')->name('installation_request');
Route::view('feedback', 'feedback')->name('feedback');
Route::view('accessory_req', 'accessory_req')->name('accessory_req');
Route::view('extend_warrenty', 'extend_warrenty')->name('extend_warrenty');

Route::get('get_app_user', [Admin_controller::class, 'get_app_user'])->name('get_app_user');

Route::get('get_service_request', [Admin_controller::class, 'get_service_request'])->name('get_service_request');
Route::get('get_installation_request', [Admin_controller::class, 'get_installation_request'])->name('get_installation_request');
Route::get('get_feedback', [Admin_controller::class, 'get_feedback'])->name('get_feedback');
Route::get('get_accessory_req', [Admin_controller::class, 'get_accessory_req'])->name('get_accessory_req');
Route::get('get_extend_warrenty', [Admin_controller::class, 'get_extend_warrenty'])->name('get_extend_warrenty');


Route::get('log_out', [Admin_controller::class, 'log_out'])->name('log_out');
Route::get('master', [Admin_controller::class, 'appliance_accessory_master'])->name('master');
Route::get('add_appliance', [Admin_controller::class, 'add_appliance'])->name('add_appliance');
Route::get('delete_appliance', [Admin_controller::class, 'delete_appliance'])->name('delete_appliance');
Route::get('edit_appliance', [Admin_controller::class, 'edit_appliance'])->name('edit_appliance');
Route::get('update_appliance', [Admin_controller::class, 'update_appliance'])->name('update_appliance');

Route::get('add_accessory', [Admin_controller::class, 'add_accessory'])->name('add_accessory');
Route::get('delete_accessory', [Admin_controller::class, 'delete_accessory'])->name('delete_accessory');
Route::get('edit_accessory', [Admin_controller::class, 'edit_accessory'])->name('edit_accessory');
Route::get('update_accessory', [Admin_controller::class, 'update_accessory'])->name('update_accessory');
Route::get('change_status', [Admin_controller::class, 'change_status'])->name('change_status');

Route::get('resell_master', [Admin_controller::class, 'resell_master'])->name('resell_master');
Route::post('insert_resell_master', [Admin_controller::class, 'insert_resell_master'])->name('insert_resell_master');
Route::get('delete_resell', [Admin_controller::class, 'delete_resell'])->name('delete_resell');
Route::get('get_resell_data', [Admin_controller::class, 'get_resell_data'])->name('get_resell_data');
Route::get('edit_resell_item', [Admin_controller::class, 'edit_resell_item'])->name('edit_resell_item');
Route::view('resell_order', 'resell_order')->name('resell_order');
Route::get('get_resell_order', [Admin_controller::class, 'get_resell_order'])->name('get_resell_order');


});