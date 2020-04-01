<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validate;
use DB;

use App\Post;
use App\Category;


class CotegoriesController extends Controller
{
    //カテゴリを取得
    public function show (){

        $userGender = Auth::user()->gender;

        if ($userGender == 1){
            $categories = Category::where('category_type','=',0)->select('id','category_name')->get();
        } else {
            $categories = Category::select('id','category_name')->get();
        } 
        return response()->json(['categories'=>$categories], 200);
    }
}
