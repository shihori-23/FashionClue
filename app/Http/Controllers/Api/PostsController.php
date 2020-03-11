<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validate;
use DB;

use App\Post;
use App\PostPhoto;
use App\PostNotice;
use App\User;
use App\Taste;
use App\TasteUser;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function save(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'text' => 'required | max:500',
            'image' => 'max:3000000 | nullable'
        ]);

        $userId = Auth::id();

        $posts = new Post;
        $posts->user_id = $userId;
        $posts->category = $request->category;
        $posts->text = $request->text;


        $posts->post_image  = "image.png";
        $posts->save();

        //　格納されたデータの情報を取得
        $id = $posts->id;

        //もしファイルがあれば更新
        if ($request->hasFile('image')) {

            $images = $request->file('image');
            foreach ($images as $image) {
                //ファイルが保存される先の名前
                $path =  $image->store('public/image/profile');
                $saveImagePath = str_replace('public/', 'storage/', $path);

                //保存される名前を決める
                $photo = PostPhoto::create([
                    'post_id' => $id,
                    'image_url' => $saveImagePath,
                ]);
            }
        }

        return response()->json(['id' => $id], 200);
    }

    //　質問詳細ページへの質問情報の取得
    public function show($id)
    {
        $postId = $id;

        $posts = Post::where('id', '=', $id)->first();

        //　質問したユーザーの情報を取得
        $postUserId = $posts->user_id;
        $postUser = User::where('id', '=', $postUserId)->select('name', 'gender', 'age', 'image')->first();

        //　質問したユーザーの好みの情報を取得
        $selectedTastes = TasteUser::where('user_id', '=', $postUserId)->select('taste_id')->get();

        //　質問に対する回答を取得
        $postedAnswers = DB::table('answers as a')
            ->join('users as u', 'u.id', '=', 'a.user_id')
            ->where('a.post_id', '=', $postId)
            ->select('u.id', 'u.name', 'u.image', 'a.text', 'a.url', 'a.answer_image')
            ->get();

        return response()->json(['posts' => $posts, 'postUser' => $postUser, 'selectedTastes' => $selectedTastes, 'postedAnswers' => $postedAnswers], 200);
    }
}
