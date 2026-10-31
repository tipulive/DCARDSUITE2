<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CompanyController;


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
Route::get('/promotion', function () {
    return view('promotion');
});
Route::get('/cbm', function () {
    return view('cbm');
});
Route::get('/testphone', function () {
    return view('testphone');
});
Route::get('admin/{uid}', function ($uid) {//create Company
    $user=DB::select("select subscriber,CompanyName,uid from admins where uid=:uid",array(
        "uid"=>$uid
    ));
    if($user){
        return view('/components/auth/admin/company', ['user' => $user]);

    }

});
Route::get('company/{subscriber}', function ($subscriber) {//create User Under Company
    $user=DB::select("select subscriber,CompanyName,uid from admins where subscriber=:subscriber",array(
        "subscriber"=>$subscriber
    ));

    if($user){
        return view('/components/auth/company/registerUser', ['user' => $user]);

    }

});

Route::get('/ViewCard', function () {
    return view('PrintCard');
});
Route::get('/ViewQrProduct', function () {
    return view('PrintProduct');
});

Route::get('/submit-form','TestController@submitForm')->middleware('auth:sanctum');


Route::get('qrcode', 'TestController@generateQrCode');
Route::get('testPostdata', 'TestController@testPostdata');


Route::get('/login','AccountController@login')->name('login');
Route::get('/', function () {
    return view('homepage');
});

Route::get('/wel', function () {
    return view('welcome');
});

Route::get('/user', function () {
    return view('OrderRequest');
});
Route::get('/userlogin', function () {
    //return view('login');
    return view('/components/auth/users/login');
});

Route::get('/register', function () {
    //return view('register');
    return view('/components/auth/users/register');
});


    // API routes requiring authentication
    Route::get('/admin', function () {
        return view('adminpage');

       // return view('adminpage', ['token' => $token]);
    });



Route::get('/adminlogin', function () {
    //return view('adminlogin');
    return view('/components/auth/admin/login');
});

Route::get('/adminregister', function () {
    //return view('adminregister');
    return view('/components/auth/admin/register');
});

