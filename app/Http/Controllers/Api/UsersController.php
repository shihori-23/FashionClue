<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\User;

class UsersController extends Controller
{   
    //　ログインユーザーのuidを取得
    public function uid()
    {
        $user = Auth::user()->id;
        return response()->json(['uid' => $user], 200);
    }

    // ユーザーのプロフィール取得
    public function show()
    {
        $user = Auth::user();                
        $array = array('name'=>$user->name,'email'=>$user->email,'image'=>$user->image,'bio'=>$user->bio,'age'=>$user->age,'gender'=>$user->gender);
        //表示に必要な部分だけ配列にぶち込んでjsonで渡す
        
        return response()->json(['profile'=>$array], 200);
    }

    //プロフィール編集
    public function edit(Request $request)
    {   

        // return response()->json(['done'=>$request->gender], 200);

        $user = User::find(Auth::id());
        //もしファイルがあれば更新
        if ($request->file('image')) {   
            //ファイルが保存される先の名前
            $user->image = $request->file('image')->store('public/image/profile');
            //ここで、こっちが保存される先の名前を決める
            // $user->image = str_replace('public/', '/image/profile', $profile_image->image_url);
            $user->image = str_replace('public/', 'storage/', $user->image);
        }
        //未入力のやつにnullっていう単語が入っちゃう問題の解決のためめんどくさいif文があります。
        //↑migrationファイルにnullableを設定すれば回避できますよー！
        if ($request->has('bio')) {
            $user->bio = $request->bio;
        } else {
            $user->bio = null;
        }
        if ($request->has('age')) {
            $user->age = $request->age;
        } else {
            $user->age = null;
        }
        if ($request->has('gender')) {
            //　性別をint形式に変換
            $gender = $request->gender;
            if ($gender == "レディース"){
                $user->gender = 0;
            } else if($gender == "メンズ"){
                $user->gender = 1;
            }
        } else {
            $user->gender = null;
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        //　更新したユーザー情報の取得
        $user = Auth::user();
        $array = array('name'=>$user->name,'email'=>$user->email,'image'=>$user->image,'bio'=>$user->bio,'age'=>$user->age,'gender'=>$user->gender);

        return response()->json(['done'=>true,'profile'=>$array], 200);
    }
}
