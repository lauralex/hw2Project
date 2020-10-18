<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');

});
*/
Route::redirect('/', 'home')->name('root');


Auth::routes(['verify'=>false, 'reset'=>false]);

Route::get('home', 'HomeController@index')->name('home');

Route::get('/create_post', 'CreatePostController@choose_service')->name('create_post');

Route::post('/create_post/submit', 'CreatePostController@create_post')->name('submit_post');

Route::post('/create_post/do_search_content', 'DoSearchContentController@search_content')->name('search_content');

Route::get('/home/post_list', 'HomeController@post_list')->name('post_list');

Route::post('/upload', 'UploadController@upload')->name('upload');

Route::get('/search_people', 'SearchPeopleController@index')->name('search_people_index');

Route::get('/search_people/do_search_user', 'SearchPeopleController@getUser')->name('search_user');

Route::get('/search_people/do_search_all', 'SearchPeopleController@getAll')->name('search_all_users');

Route::post('/follow_user', 'FollowController@followUser')->name('follow_user');

Route::post('/store_like', 'LikeController@storeLike')->name('store_like');

Route::get('/get_likers', 'LikeController@getLikers')->name('get_likers');

Route::get('/searchUser', 'Auth\RegisterController@searchUser')->name('check_user');