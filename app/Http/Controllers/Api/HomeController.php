<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;

use App\User;
use App\Post;
use App\BookmarkPost;
use App\Taste;
use App\TasteUser;
use App\Answer;
use App\BookmarkAnswer;
    

    class HomeController extends Controller
    {
        
        //　ホーム画面に表示するデータの取得
        public function show()
        {
            $ladysQuerys = DB::table('posts as p')
                                    ->join('users as u', 'u.id','=', 'p.user_id')
                                    ->where('u.gender','=',0)
                                    ->orderBy('p.created_at','desc')
                                    ->select('p.id as post_id','p.text','p.post_image','p.category','p.created_at','u.id as user_id','u.name','u.image','u.age','u.gender')
                                    ->get();
            $ladysPostsData = [];

            foreach ($ladysQuerys as $ladysQuery) {
                $object = $ladysQuery;
                $answerCount = Answer::where('post_id','=',$ladysQuery->post_id)->count();

                $object->answer_count = $answerCount;
                $ladysPostsData[]=$object; 
            }

                //もう一つの取得方法（大きな差はないが、性別を途中で変える可能性があればこっちの方が良い？）
                // $ladysQuerys = Post::where('gender_id','=',0)
                //                         ->orderBy('created_at','desc')
                //                         ->get();
                // $ladysPostsData = [];

                // foreach ($ladysQuerys as $ladysQuery) {
                    // $object = Post::where('id','=',$ladysQuery->id)->first();
                    // $object = $ladysQuery;
                    // $user = User::where('id','=',$ladysQuery->user_id)->first();
                    // $answerCount = Answer::where('post_id','=',$ladysQuery->post_id)->count();
                    // $object->user_id = $user->id;
                    // $object->user_name = $user->name;
                    // $object->user_image = $user->image;
                    // $object->age = $user->age;
                    // $object->gender= $user->gender;
                    // $object->answer_count = $answerCount;
                    // $ladysPostsData[]=$object; 
                // }
                //とりあえずここまで残しておきます〜

            $mensQuerys = DB::table('posts as p')
                                    ->join('users as u', 'u.id','=', 'p.user_id')
                                    ->where('u.gender','=',1)
                                    ->orderBy('p.created_at','desc')
                                    ->select('p.id as post_id','p.text','p.post_image','p.category','p.created_at','u.id as user_id','u.name','u.image','u.age','u.gender')
                                    ->get();
            $mensPostsData = [];

            foreach ($mensQuerys as $menssQuery) {
                $object = $mensQuery;
                $answerCount = Answer::where('post_id','=',$mensQuery->post_id)->count();

                $object->answer_count = $answerCount;
                $mensPostsData[]=$object; 
            }

            //ログインユーザーがお気に入りした投稿のidを取得
            $bookmarks = BookmarkPost::where('user_id','=', Auth::id())
                                        ->select('post_id')
                                        ->get();

                $postBookmarkedId = [];
                foreach($bookmarks as $bookmark){
                $postBookmarkedId[] = $bookmark->post_id;
                }

            return response()->json(['ladysPostsData'=>$ladysPostsData,'mensPostsData'=>$mensPostsData,'postBookmarkedId'=>$postBookmarkedId], 200);
        }
    }
    
    