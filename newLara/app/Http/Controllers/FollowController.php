<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function followUser(Request $request) {
        $validated = $request->validate([
            'follow'=>'required|numeric|exists:hw2_users,id',
        ]);

        $isFollowed = Auth::user()->hw2Users_followed()->wherePivot('followed', '=', $validated['follow']);

        if ($isFollowed->exists()) {
            Auth::user()->hw2Users_followed()->detach($isFollowed->first(['hw2_users.id']));
            return response('User unfollowed');
        } else {
            Auth::user()->hw2Users_followed()->attach($validated['follow']);
            return response('User followed');
        }
    }
}
