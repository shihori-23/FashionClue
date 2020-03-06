<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\User;
use App\Taste;
use App\TasteUser;

class UsersController extends Controller
{   
    //　ログインユーザーのuidを取得
    public function uid()
    {
        $user = Auth::user()->id;
        return response()->json(['uid' => $user], 200);
    }

    // ユーザーのプロフィール取得とテイストの取得
    public function show()
    {
        $user = Auth::user(); 
        $user_gender = Auth::user()->gender;               
        $array = array('name'=>$user->name,'email'=>$user->email,'image'=>$user->image,'bio'=>$user->bio,'age'=>$user->age,'gender'=>$user->gender);
        
        //　性別判断し、存在するテイストを取得
        $taste = Taste::where('taste_type','=',$user_gender)->select('id','taste_name')->get();
        //　性別登録をしているか判定
        if ($user_gender === null) {
            $genderNotEntered = false;
        } else {
            $genderNotEntered = true;
        }
        // $array2 = array('id'=>$taste->id,'taste_name'=>$taste->taste_name);
        return response()->json(['profile'=>$array,'tastes'=>$taste,'notEntered'=>$genderNotEntered], 200);
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
        //　フォームに入力さえたデータ
        if ($request->has('bio')) {
            $user->bio = $request->bio;
        } 
        if ($request->has('age')) {
            $user->age = $request->age;
        } 
        if ($request->has('gender')) {
            //　性別をint形式に変換
            $gender = $request->gender;
            if ($gender == "レディース"){
                $user->gender = 0;
            } else if($gender == "メンズ"){
                $user->gender = 1;
            }
        } 
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        //　更新したユーザー情報の取得
        $user_key = Auth::id();
        $users_profile = User::find(Auth::id());
        $array = array('name'=>$users_profile->name,'email'=>$users_profile->email,'image'=>$users_profile->image,'bio'=>$users_profile->bio,'age'=>$users_profile->age,'gender'=>$users_profile->gender);

        return response()->json(['done'=>true,'profile'=>$array], 200);
    }
    //　テイストの編集
    public function editTaste(Request $request){

        //　Requestを定義
        $selectedTastes = $request->tastes_id;
        $user_id = Auth::id();
        $dt = now();

        //　一旦ログインユーザーのテイストデータを消す
        $oldTastes = TasteUser::where('user_id','=',$user_id)->get();
        if ($oldTastes->isEmpty()) {
        //　すでにテイストを登録してなければ何もしない            
        } else {
            $delete = TasteUser::where('user_id','=',$user_id)->delete();
            $tastes = [];

            for($i = 0; $i < count($selectedTastes); $i++){
                array_push($tastes,['user_id' => $user_id,'taste_id'=> $selectedTastes[$i],'created_at' => $dt,'updated_at' => $dt]);
            }
            $tastesUser = new TasteUser;
            $tastesUser->insert($tastes);
        }

        return response()->json(['done'=>true], 200);
    }
}
