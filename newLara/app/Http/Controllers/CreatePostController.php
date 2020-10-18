<?php

namespace App\Http\Controllers;

use App\Hw2Post;
use App\Hw2User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CreatePostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function choose_service() {
        return view('create_post');
    }

    function populateAniList(Hw2Post $hw2Post, $postUri)
    {
        if (preg_match('/(anilist)/i', $postUri) == 1 && preg_match('/(manga)/i', $postUri) == 1) {
            preg_match('/\d{2,}/', $postUri, $matches);
            $hw2Post->url_an = "http://anilist.co/manga/{$matches[0]}";
            $hw2Post->save();
        } else {
            preg_match('/\d{2,}/', $postUri, $matches);
            $hw2Post->url_an = "http://anilist.co/anime/{$matches[0]}";
            $hw2Post->save();
        }
    }

    public function create_post(Request $request) {
        Validator::make($request->all(), [
            'uri'=>['required', 'url', 'max:255'],
            'title'=>['required', 'string', 'max:255'],
			'yt_url'=>['nullable', 'url', 'max:255'],
        ], [
            'uri.required'=>'Uri is empty!',
            'title.required'=>'You need a title here!',
        ])->validate();

        if (isset($request->yt_url)) {
            Hw2Post::create([
                'post_title'=>$request->title,
                'post_url'=>$request->uri,
                'hw2_user_id'=>Auth::id(),
                'url_yt'=>$request->yt_url,
            ]);
        } else {
            $createdEntry = Hw2Post::create([
                'post_title'=>$request->title,
                'post_url'=>$request->uri,
                'hw2_user_id'=>Auth::id(),
            ]);
            $this->populateAniList($createdEntry, $request->uri);

        }

        /*
        $validated = $request->validate([
            'uri'=>['required'],
            'title'=>['required'],
        ]);
        */

    }
}
