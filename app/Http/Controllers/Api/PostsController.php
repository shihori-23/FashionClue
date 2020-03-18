<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;

use App\Post;
use App\PostNotice;
use App\User;
use App\Taste;
use App\TasteUser;
    

    class PostsController extends Controller
    {
        // 質問投稿のデータを保存
        public function save(PostRequest $request)
        {

            $userId = Auth::id();
            $userGender = Auth::user()->gender;
    
            $posts = new Post;
            $posts->user_id = $userId;
            $posts->category_id = $request->category_id;
            $posts->text = $request->text;
            $posts->gender_id = $userGender;

            //もしファイルがあれば更新
            if ($request->file('image')) {   
                //ファイルが保存される先の名前
                $posts->post_image = $request->file('image')->store('public/image/profile');
                //保存される名前を決める
                $posts->post_image = str_replace('public/', 'storage/', $posts->post_image);
            }
            $posts->save();

            //　格納されたデータの情報を取得
            $id = $posts->id;

            return response()->json(['id'=>$id], 200);
        }
        
        //　質問詳細ページへの質問情報の取得
        public function show($id)
        {
            $postId = $id;

            $postContent = DB::table('posts as p')
                                ->join('categories as c','c.id','=','p.category_id')
                                ->where('p.id', '=', $id)
                                ->first();

            //　質問したユーザーの情報を取得(カテゴリ情報を別テーブルから取得するように変更) 
            $postUserId = $postContent->user_id;
            $postUser = User::where('id', '=', $postUserId)->select('name','gender','age','image')->first();

            //　質問したユーザーの好みの情報を取得
            // $selectedTastes = TasteUser::where('user_id','=',$postUserId)->select('taste_id')->get();
            $selectedTastes = DB::table('taste_user as tu')
                                ->join('tastes as t', 't.id','=', 'tu.taste_id')
                                ->where('tu.user_id','=',$postUserId)
                                ->select('t.taste_name')
                                ->get();

            //　質問に対する回答を取得
            $postedAnswers = DB::table('answers as a')
                        ->join('users as u', 'u.id', '=', 'a.user_id')
                        ->where('a.post_id', '=', $postId)
                        ->select('a.id','u.id as user_id', 'u.name', 'u.image', 'a.text', 'a.url', 'a.answer_image', 'a.created_at')
                        ->get();

            return response()->json(['postContent'=>$postContent, 'postUser'=>$postUser, 'selectedTastes'=>$selectedTastes,'postedAnswers'=>$postedAnswers], 200);
        }
    }
    
    