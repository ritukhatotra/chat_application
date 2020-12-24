<?php

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
Route::get('/', 'HomeController@login');
Route::GET('login', 'HomeController@login');
Route::GET('login', 'HomeController@login');
Route::post('login', 'HomeController@postSignIn');
Route::GET('register', 'HomeController@register');
Route::post('register', 'HomeController@postSignUp');
Route::post('checkEmail', 'HomeController@checkEmail');
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('dashboard', 'UserController@index');
    Route::get('logout', 'UserController@logout');
    Route::post('get-user-chat', 'UserController@userChat');
    Route::post('send-message', 'UserController@sendMessage');
    Route::get('delete-sender-message/{user_id}/{chat_id}', 'UserController@deleteMsgSender');
});
