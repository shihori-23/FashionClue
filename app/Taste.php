<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    //
    // protected $guarded = ["id"];
    public function users(){
        return $this->belongsToMany('App\User'); 
    }

}

