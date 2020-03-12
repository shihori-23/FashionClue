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
        //　詳細画面でお気に入りしているか確認
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

        public function save($id){

            $bookmark = New BookmarkPost;
            $bookmark->post_id = $id;
            $bookmark->user_id = Auth::id();
            $bookmark->save();

            return response()->json(['isBookmarked'=>true], 200);
        }

        public function destroy($id){

            $bookmark = BookmarkPost::where('user_id','=', Auth::id())
                                        ->where('post_id','=',$id)
                                        ->delete();

            return response()->json(['isBookmarked'=>false], 200);

        }
    }
    
    