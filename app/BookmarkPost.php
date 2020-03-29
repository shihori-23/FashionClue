<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookmarkPost extends Model
{
    // protected $guarded = ["id"];
    
    // posts tableとのリレーション
    public function post(){

        return $this->belongTo('App\Post'); 
    }

}

