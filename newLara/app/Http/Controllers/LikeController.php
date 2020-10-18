<?php

namespace App\Http\Controllers;

use App\Hw2Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Sodium\increment;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getLikers(Request $request) {
        $validated = $request->validate([
            'likers'=>'required|numeric|exists:hw2_posts,id'
        ]);

        $likersPost = Hw2Post::find($validated['likers'])->hw2Users_like()->get();
        $results = array();
        if($likersPost) {
            foreach ($likersPost as $liker) {
                $results[] = array('username'=>$liker->username, 'image'=>$liker->image);
            }
        }
        return response()->json($results);
    }

    public function storeLike(Request $request) {
        $validated = $request->validate([
            'resolveLike'=>'required|numeric|exists:hw2_posts,id'
        ]);

        $isLiked = Auth::user()->hw2Posts_like()->find($validated['resolveLike']);

        if ($isLiked) {
            Auth::user()->hw2Posts_like()->detach($validated['resolveLike']);
            $isLiked->likes--;
            $isLiked->save();
            return response('Like');
        } else {
            Auth::user()->hw2Posts_like()->attach($validated['resolveLike']);
            $likedPost = Hw2Post::find($validated['resolveLike']);
            $likedPost->likes++;
            $likedPost->save();
            return response('Unlike');
        }
    }
}
