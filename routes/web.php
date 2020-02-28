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

//　LPページのルート
Route::get('/', function () {
    return view('index');
});

//　ログインのに表示されるホーム画面のルート
Route::group(['middleware' => 'auth'], function () {
Route::get('/main', function () {
    return view('main');
});
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
