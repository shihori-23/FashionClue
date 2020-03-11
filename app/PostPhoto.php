<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostPhoto extends Model
{
    //
    protected $fillable = [
        'post_id', 'image_url'
    ];

    public function Post()
    {
        return $this->belongsTo('App/Post');
    }
}
