<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\User;
use App\Answer;
use App\BookmarkAnswer;
    
    class BookmarkAnswersController extends Controller
    {
        //　詳細画面で回答お気に入りしているか確認
        public function show($id) {

                                        
            $bookmarks = DB::table('bookmark_answers as ba')
                            ->join('answers as a', 'a.id','=', 'ba.answer_id')
                            ->where('ba.user_id','=',Auth::id())
                            ->where('a.post_id','=',$id)
                            ->select('ba.answer_id')
                            ->get();
            
            //お気に入り済のanswer_idを配列に入れる
            $bookmarksId = [];
            foreach($bookmarks as $bookmark){
                $bookmarksId[] = $bookmark->answer_id;
            }
        
            return response()->json(['bookmarkId'=>$bookmarksId], 200);
        }

        //　詳細画面の回答に対するお気に入り登録
        public function save($id) {

            $bookmark = New BookmarkAnswer;
            $bookmark->answer_id = $id;
            $bookmark->user_id = Auth::id();
            $bookmark->save();

            return response()->json(['isBookmarked'=>true], 200);

        }
        //　詳細画面の回答に対するお気に入り解除
        public function destroy($id){
            $bookmarkAnswer = BookmarkAnswer::where('user_id','=', Auth::id())
            ->where('answer_id','=',$id)
            ->delete();

            $postId = Answer::where('id','=',$id)
                                ->select('post_id')
                                ->first();

            $bookmarks = DB::table('bookmark_answers as ba')
            ->join('answers as a', 'a.id','=', 'ba.answer_id')
            ->where('ba.user_id','=',Auth::id())
            ->where('a.post_id','=',$postId->post_id)
            ->select('ba.answer_id')
            ->get();

            //お気に入り済のanswer_idを配列に入れる
            $bookmarksId = [];
            foreach($bookmarks as $bookmark){
            $bookmarksId[] = $bookmark->answer_id;
            }

            return response()->json(['bookmarksId'=>$bookmarksId], 200);
        }


    
}