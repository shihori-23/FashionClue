<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Validate;
use DB;

use App\Post;
use App\Taste;

class TastesController extends Controller
{
    //カテゴリを取得
    public function getAllTastes(Request $request)
    {

        $tastes = Taste::all();

        return response()->json(['tastes' => $tastes], 200);
    }
}
