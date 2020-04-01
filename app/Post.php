<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // protected $guarded = ["id"];
    // bookmark_posts tableとのリレーション
    public function bookmark_posts(){

        return $this->hasMany('App\BookmarkPost'); 
    }
}

