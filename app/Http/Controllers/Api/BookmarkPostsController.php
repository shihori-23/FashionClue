<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;
use App\BookmarkPost;
    
    class BookmarkPostsController extends Controller
    {   
        //　質問詳細画面でお気に入りしているか確認
        public function show($id) {

            $bookmarks = BookmarkPost::where('user_id','=', Auth::id())
                                        ->where('post_id','=',$id)
                                        ->select('post_id')
                                        ->get();

            $bookmarksId = [];
            foreach($bookmarks as $bookmark){
                $bookmarksId[] = $bookmark->post_id;
            }
        
            return response()->json(['bookmarkId'=>$bookmarksId], 200);
        }
        //　お気に入りの登録
        public function save($id){

            $bookmark = New BookmarkPost;
            $bookmark->post_id = $id;
            $bookmark->user_id = Auth::id();
            $bookmark->save();

            return response()->json(['isBookmarked'=>true], 200);
        }
        //　お気に入りの解除
        public function destroy($id){

            $bookmark = BookmarkPost::where('user_id','=', Auth::id())
                                        ->where('post_id','=',$id)
                                        ->delete();

            return response()->json(['isBookmarked'=>false], 200);
        }

        //　【お気に入り一覧ページ】質問投稿へのお気に入り取得
        public function bookmarkedDataShow(){

            $bookmarks = DB::table('bookmark_posts as bp')
                            ->join('posts as p', 'p.id', '=', 'bp.post_id')
                            ->join('categories as c', 'c.id', '=', 'p.category_id')
                            ->join('users as u', 'p.user_id', '=', 'u.id')
                            ->where('bp.user_id', '=', Auth::id())
                            ->select('p.id','u.id as user_id','u.name','u.age','u.gender','u.image','p.text','p.post_image', 'c.category_name','p.created_at')
                            ->get();
        
            return response()->json(['bookmarkedPostsData'=>$bookmarks], 200);
        }
    }
    
    