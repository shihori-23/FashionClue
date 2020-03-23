<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;

use App\User;
use App\PostNotice;
use App\AnswerNotice;

class NoticeController extends Controller
{   
    //　ヘッダーのバッジの表示非表示を切り替え
    public function show()
    {
        $userId = Auth::user()->id;

        $postNotices = DB::table('post_notices as pn')
                            ->join('posts as p', 'p.id', '=', 'pn.post_id')
                            ->where('p.user_id', '=', $userId)
                            ->where('pn.role', '=', '0')
                            ->count();

        $answerNotices = DB::table('answer_notices as an')
                                ->join('answers as a', 'a.id', '=', 'an.answer_id')
                                ->where('a.user_id', '=', $userId)
                                ->where('an.role', '=', '0')
                                ->count();

        return response()->json(['notice' => $postNotices + $answerNotices], 200);

    }
    
    //　通知ページ　UserNoticeComponentへの表示
    public function showNoticeData()
    {
        $userId = Auth::id();
        $postNoticesArray = [];
        $answerNoticesArray =[];

        //　投稿に対する回答の通知情報を取得
        $postNotices = DB::table('post_notices as pn')
                            ->join('posts as p', 'p.id', '=', 'pn.post_id')
                            ->join('answers as a', 'a.post_id', '=', 'pn.post_id')
                            ->where('p.user_id', '=', $userId)
                            ->orderBy('pn.created_at', 'desc')
                            ->select('pn.id','pn.post_id','pn.answer_owner_id','pn.created_at','pn.role')
                            ->get();
        
        //　表示に必要なデータを追加
        foreach ($postNotices as $p) {
            $object = $p;
            $answerOwnerName = User::where('id', '=', $p->answer_owner_id)->first()->name;
            $answerOwnerImage = User::where('id', '=', $p->answer_owner_id)->first()->image;
            $object->answer_owner_name = $answerOwnerName;
            $object->answer_owner_image = $answerOwnerImage;
            $postNoticesArray[] = $object;
        }

        //　評価に対する通知情報を取得
        $answerNotices = DB::table('answer_notices as an')
                            ->join('answers as a', 'a.id', '=', 'an.answer_id')
                            ->where('a.user_id', '=', $userId)
                            ->orderBy('an.created_at', 'desc')
                            ->select('an.id','an.review_owner_id','an.role','an.answer_id','an.created_at','a.post_id')
                            ->get();

        //　表示に必要なデータを追加
        foreach ($answerNotices as $a) {
            $object = $a;
            $reviewOwnerName = User::where('id', '=', $a->review_owner_id)->first()->name;
            $reviewOwnerImage = User::where('id', '=', $a->review_owner_id)->first()->image;
            $object->review_owner_name = $reviewOwnerName;
            $object->review_owner_image = $reviewOwnerImage;
            $answerNoticesArray[] = $object;
        }

        //　レビューとコメントの配列を結合
        $notices = array_merge_recursive($postNoticesArray, $answerNoticesArray);

        // //配列の中身を並び替える collectヘルパにデータを渡す
        $collection = collect($notices);

        // //日付を最新順に並び替えを行う
        $sorted = $collection->sortByDESC('created_at')->values();

        // //　roleを変更処理
        foreach ($postNotices as $p) {
            $id =$p->id;
            DB::table('post_notices')->where('id', $id)
            ->update(['role' => 1]);
        };

        foreach ($answerNotices as $a) {
            $id =$a->id;
            DB::table('answer_notices')->where('id', $id)
            ->update(['role' => 1]);
        };

        return response()->json(['postNoticesData'=>$postNoticesArray,'answerNoticeData'=>$answerNoticesArray,'userNoticeData'=>$sorted], 200);
    }
}
