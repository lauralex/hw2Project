<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hw2Post extends Model
{
    protected $fillable = [
        'post_title', 'post_url', 'date', 'likes', 'url_yt', 'url_an', 'hw2_user_id',
    ];

    public function hw2User() {
        return $this->belongsTo('App\Hw2User');
    }
    public function hw2Users_like() {
        return $this->belongsToMany('App\Hw2User');
    }
    //
}
