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
    Route::get('profile/show', 'Api\UsersController@showProfile');
    //　ログイン中のユーザーの編集用プロフィール取得
    Route::get('profile/get', 'Api\UsersController@show');
    //　プロフィールの編集
    Route::post('profile/edit', 'Api\UsersController@edit');
    //　テイストの編集
    Route::post('tastes/edit', 'Api\UsersController@editTaste');

    //　カテゴリ情報を取得
    Route::get('category/get', 'Api\CotegoriesController@show');
    //　質問の投稿
    Route::post('question/post', 'Api\PostsController@save');

    //　質問詳細画面への投稿の表示
    Route::get('question/get/{postId}', 'Api\PostsController@show');
    //　回答投稿
    Route::post('answer/post', 'Api\AnswersController@save');
    //　質問投稿に対するお気に入りの有無を確認
    Route::get('bookmark/get/{id}', 'Api\BookmarkPostsController@show');
    //　投稿に対するお気に入り追加
    Route::post('post_bookmark/post/{id}', 'Api\BookmarkPostsController@save');
    //　投稿に対するお気に入りの取り消し
    Route::post('post_bookmark/destory/{id}', 'Api\BookmarkPostsController@destroy');
    //　回答に対するお気に入りの有無を確認
    Route::get('answer_bookmark/get/{id}', 'Api\BookmarkAnswersController@show');
    //　回答に対するお気に入り追加
    Route::post('answer_bookmark/post/{id}', 'Api\BookmarkAnswersController@save');
    //　回答に対するお気に入りの取り消し
    Route::post('answer_bookmark/destory/{id}', 'Api\BookmarkAnswersController@destroy');
    //　回答に対する評価
    Route::post('best_answer/post/{id}', 'Api\ReviewsController@save');

    //　質問投稿に対するお気に入り一覧の取得
    Route::get('post_bookmark/get', 'Api\BookmarkPostsController@bookmarkedDataShow');
    //　回答に対するお気に入り一覧の取得
    Route::get('answer_bookmark/get', 'Api\BookmarkAnswersController@bookmarkedDataShow');

    //　通知ページ
    Route::get('notice/get', 'Api\NoticeController@showNoticeData');
//認証閉じタグここまで
});
//認証閉じタグここまで