<?php

use Illuminate\Http\Request;

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

//　はじめから記述されていたもの
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//　API定義
//　認証後であれば下記ルート定義が有効になる
Route::group(['middleware' => 'auth'], function () {
    //　ログイン中のuidの取得
    Route::get('uid', 'Api\UsersController@uid');
    //　ログイン中のユーザーのプロフィール取得
    Route::get('get/profile', 'Api\UsersController@show');
    //　プロフィールの編集
    Route::post('edit/profile', 'Api\UsersController@edit');
    //　テイストの編集
    Route::post('edit/tastes', 'Api\UsersController@editTaste');
    //　質問の投稿
    Route::post('post/question', 'Api\PostsController@save');
    //　質問詳細画面への投稿の表示
    Route::get('get/question/{postId}', 'Api\PostsController@show');
    //　回答投稿
    Route::post('post/answer', 'Api\AnswersController@save');
//認証閉じタグここまで
});
//認証閉じタグここまで