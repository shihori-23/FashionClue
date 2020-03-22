<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnswerRequest;
use Illuminate\Http\Request;
use Auth;
use Validate;

use DB;
use App\Answer;
use App\AnswerNotice;
use App\Post;
use App\PostNotice;
use App\User;
    
    class AnswersController extends Controller
    {
        //　回答投稿
        public function save(AnswerRequest $request)
        {

            $userId = Auth::id();
            $postId = $request->postId;
    
            $answers = new Answer;
            $answers->user_id = $userId;
            $answers->post_id = $request->postId;
            $answers->text = $request->text;
            $answers->url = $request->url;

            //もしファイルがあれば更新
            if ($request->file('image')) {   
                //ファイルが保存される先の名前
                $answers->answer_image = $request->file('image')->store('public/image/profile');
                //保存される名前を決める
                $answers->answer_image = str_replace('public/', 'storage/', $answers->answer_image);
            }
            $answers->save();

            // 回答を取得            
            $postedAnswers = DB::table('answers as a')
                                ->join('users as u', 'u.id', '=', 'a.user_id')
                                ->where('a.post_id', '=', $postId)
                                ->select('a.id','u.id as user_id', 'u.name', 'u.image', 'a.text', 'a.url', 'a.answer_image', 'a.created_at')
                                ->get();

            //　通知用のテーブルにデータを保存
            $postNotice = new PostNotice;
            $postNotice->post_id = $postId;
            $postNotice->answer_owner_id = $userId; //回答者のuser_id
            $postNotice->role = 0; //未読・既読の管理　未読の場合「０」
            $postNotice->save();
            
            return response()->json(['id'=>$answers,'postedAnswers'=>$postedAnswers], 200);
        }
    
        
    }
    
    