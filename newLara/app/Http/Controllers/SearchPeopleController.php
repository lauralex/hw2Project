<?php

namespace App\Http\Controllers;

use App\Hw2Post;
use App\Hw2User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SearchPeopleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getUser(Request $request) {
        $validated = $request->validate([
            'searchedUser'=>'required|string|max:255',
        ]);
        $foundUsers = Hw2User::where('username', 'like', '%'.$validated['searchedUser'].'%')->get();
        $users = array();
        foreach ($foundUsers as $foundUser) {
            $username = $foundUser->username;
            $image = $foundUser->image;
            $UID = $foundUser->id;

            $checkFollow = $foundUser->hw2Users_follower()->where('follower', '=', Auth::id())->exists();
			$foundImage = preg_match('/http(s)?:\/\//', $image) == 1 ? $image : route('root').$image;
            $users[] = array('followed'=> $checkFollow, 'UID'=> $UID, 'foundUser'=> $username, 'foundImage'=> $foundImage);
        }
        return response()->json($users);
    }

    public function getAll() {
        $users = Hw2User::all();
        $userArray = array();
        foreach ($users as $hw2User) {
            $username = $hw2User->username;
            $image = $hw2User->image;
            $UID = $hw2User->id;

            $checkFollow = $hw2User->hw2Users_follower()->where('follower', '=', Auth::id())->exists();
			$foundImage = preg_match('/http(s)?:\/\//', $image) == 1 ? $image : route('root').$image;
            $userArray[] = array('followed'=> $checkFollow, 'UID'=> $UID, 'foundUser'=> $username, 'foundImage'=> $foundImage);
        }
        return response()->json($userArray);
    }

    public function index() {
        return view('search_people');
    }
}
