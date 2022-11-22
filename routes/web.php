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

Route::get('/', function () {
    return view('welcome');
});

Route::get("test", function () {
    return view('test');
});

Route::get("register", "ImgController@getRegister");

Route::post("register", "ImgController@postRegister");

Route::get("login", "ImgController@getLogin");

Route::post("login", "ImgController@postLogin");

Route::get("logout", "ImgController@getLogout");

Route::get('Upload' , "ImgController@getUploadImg");

Route::post('Upload' , "ImgController@postUploadImg");

Route::get('ImageData' , "ImgController@getImageData");

Route::post('convert' , "ImgController@convertImageData");

Route::get('taixuong' , "ImgController@download_img");

Route::get('delete/{id}',"ImgController@deleteImg" );