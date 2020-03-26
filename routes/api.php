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

    //　通知があるか取得
    Route::get('notice','Api\NoticeController@show');

    //　ホーム画面で必要なデータの取得
    Route::get('get/home', 'Api\HomeController@show');

    //　ログイン中のユーザーのプロフィール取得
    Route::get('show/profile', 'Api\UsersController@showProfile');
    //　ログイン中のユーザーの編集用プロフィール取得
    Route::get('get/profile', 'Api\UsersController@show');
    //　プロフィールの編集
    Route::post('edit/profile', 'Api\UsersController@edit');
    //　テイストの編集
    Route::post('edit/tastes', 'Api\UsersController@editTaste');

    //　カテゴリ情報を取得
    Route::get('get/category', 'Api\CotegoriesController@show');
    //　質問の投稿
    Route::post('post/question', 'Api\PostsController@save');

    //　質問詳細画面への投稿の表示
    Route::get('get/question/{postId}', 'Api\PostsController@show');
    //　回答投稿
    Route::post('post/answer', 'Api\AnswersController@save');
    //　質問投稿に対するお気に入りの有無を確認
    Route::get('get/bookmark/{id}', 'Api\BookmarkPostsController@show');
    //　投稿に対するお気に入り追加
    Route::post('post/post_bookmark/{id}', 'Api\BookmarkPostsController@save');
    //　投稿に対するお気に入りの取り消し
    Route::post('destory/post_bookmark/{id}', 'Api\BookmarkPostsController@destroy');
    //　回答に対するお気に入りの有無を確認
    Route::get('get/answer_bookmark/{id}', 'Api\BookmarkAnswersController@show');
    //　回答に対するお気に入り追加
    Route::post('post/answer_bookmark/{id}', 'Api\BookmarkAnswersController@save');
    //　回答に対するお気に入りの取り消し
    Route::post('destory/answer_bookmark/{id}', 'Api\BookmarkAnswersController@destroy');
    //　回答に対する評価
    Route::post('post/best_answer/{id}', 'Api\ReviewsController@save');

    //　質問投稿に対するお気に入り一覧の取得
    Route::get('get/post_bookmark', 'Api\BookmarkPostsController@bookmarkedDataShow');
    //　回答に対するお気に入り一覧の取得
    Route::get('get/answer_bookmark', 'Api\BookmarkAnswersController@bookmarkedDataShow');

    //　通知ページ
    Route::get('get/notice', 'Api\NoticeController@showNoticeData');
//認証閉じタグここまで
});
//認証閉じタグここまで