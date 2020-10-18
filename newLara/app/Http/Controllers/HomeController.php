<?php

namespace App\Http\Controllers;

use App\Hw2Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\Decimal128;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function post_list() {

        //$relatedPosts = DB::table('hw2_posts')->where('hw2_posts.hw2_user_id', '=', Auth::id())->orWhereIn('hw2_posts.hw2_user_id', DB::table('hw2_user_follow')->select('followed')->where('follower', '=', Auth::id()))->get();
        $relatedPosts = Auth::user()->hw2Posts()->orWhereIn('hw2_user_id', Auth::user()->hw2Users_followed()->pluck('followed'))->orderByDesc('created_at')->get();
        //$debug = Auth::user()->hw2Posts()->orWhereIn('hw2_user_id', Auth::user()->hw2Users_followed()->get(['hw2_users.id']))->orderByDesc('created_at')->toSql();
        $arrayOfInfo = array();
        foreach ($relatedPosts as $relatedPost) {

            $likeRes = Auth::user()->hw2Posts_like()->where('hw2_posts.id', '=', $relatedPost->id)->count();
            array_push($arrayOfInfo, array('postId' => $relatedPost->id, 'postTitle' => $relatedPost->post_title, 'postUrl' => $relatedPost->post_url, 'date' => $relatedPost->created_at->format('Y-m-d H:i:s'), 'like' => $likeRes > 0, 'num_likes' => $relatedPost->likes, 'yt_url' => $relatedPost->url_yt, 'an_url' => $relatedPost->url_an, 'username'=>$relatedPost->hw2User->username));
            //array_push($arrayOfInfo, array('postId' => $relatedPost->id, 'postTitle' => $relatedPost->post_title, 'postUrl' => $relatedPost->post_url, 'date' => $relatedPost->created_at, 'like' => $likeRes > 0, 'num_likes' => $relatedPost->likes, 'yt_url' => $relatedPost->url_yt, 'an_url' => $relatedPost->url_an, 'username'=>DB::table('hw2_users')->where('id' , '=', $relatedPost->hw2_user_id)->first()));
        }

        return response()->json($arrayOfInfo);
        /*
        $query = "SELECT postUrl, postTitle, date, postId, likes, url_yt, url_an, username from hw1_posts join hw1_users on hw1_posts.postUser = hw1_users.ID
        where username = '{$_SESSION['username']}'
           OR postUser in (select followed from hw1_follow join hw1_users on followerId = ID where username = '{$_SESSION['username']}') ORDER BY date DESC";// AGGIUNGERE LA CONDIZIONE OR PER GLI ALTRI UTENTI

        $queryRes = mysqli_query($conn, $query);
        $arrayOfInfo = array();

        if (!$queryRes) {
            mysqli_close($conn);
            http_response_code(404);
            exit();
        }

        while ($row = mysqli_fetch_assoc($queryRes)) {
            $query = "SELECT postId from hw1_postlike join hw1_users on userId = ID where username = '{$_SESSION['username']}' and postId = {$row['postId']}";

            $likeRes = mysqli_query($conn, $query);


            array_push($arrayOfInfo, array('postId' => $row['postId'], 'postTitle' => $row['postTitle'], 'postUrl' => $row['postUrl'], 'date' => $row['date'], 'like' => $likeRes && mysqli_num_rows($likeRes) > 0, 'num_likes' => $row['likes'], 'yt_url' => $row['url_yt'], 'an_url' => $row['url_an'], 'username'=>$row['username']));
            mysqli_free_result($likeRes);
        }
        mysqli_free_result($queryRes);
        mysqli_close($conn);
        echo json_encode($arrayOfInfo);
        */
    }

}
