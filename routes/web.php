<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth','twoFactor'])->group(function(){
    Route::get('otp','OTPController@index')->name('otp.index');
    Route::post('otp/verify','OTPController@verifyPass')->name('otp.verify');
    Route::post('otp/resend','OTPController@resendPass')->name('otp.resend');
    // Route::get('dashboard',function(){return view('dashboard');});
    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes(['register'=>false]);

