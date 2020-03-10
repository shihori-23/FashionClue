<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        public function save(Request $request)
        {
            $user = $request;
            return response()->json(['id'=>$user], 200);
        }
    
        
    }
    
    