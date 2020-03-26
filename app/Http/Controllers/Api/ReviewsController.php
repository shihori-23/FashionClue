<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validate;
use DB;
use App\Review;
use App\Answer;
use App\Post;
use App\PostNotice;
use App\AnswerNotice;
    
    class ReviewsController extends Controller
    {
        public function save($id) {

            // ベストアンサーをreviewテーブルに格納
            $post_id = Answer::where('id','=',$id)->first()->post_id;
            $isReviewed = Review::where('post_id','=',$post_id)->first();

            if ($isReviewed) {
                Review::where('post_id','=',$post_id)->delete();
                AnswerNotice::where('post_id','=',$post_id)->delete();
            }

            $review = New Review;
            $review->answer_id = $id;
            $review->post_id = $post_id;
            $review->save();

            // Posts　tableのステータスを更新
            DB::table('posts')->where('id', $post_id)
            ->update(['status' => 1]);

            // 通知用のAnswerNotice tableにデータを保存
            $answerNotice = New AnswerNotice;
            $answerNotice->review_owner_id = Auth::id();
            $answerNotice->answer_id = $id;
            $answerNotice->post_id = $post_id;
            $answerNotice->role = 0;
            $answerNotice->save();

            return response()->json(['id'=>$id], 200);
        }
    }
    
    