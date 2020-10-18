<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoSearchContentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    private function AniList_proc($search_query)
    {

        $query = "query {
            Page(page: 1, perPage: 10) {
                media(search: \"$search_query\") {
                    title {
                        romaji
                    }
                    coverImage {
                        extraLarge
                    }
                }
            }
        }";

        $variables = array();

        $post = array(
            'query' => $query,
            'variables' => $variables
        );

        $curl_handle = curl_init("https://graphql.anilist.co");

        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, http_build_query(
            $post
        ));

        $res = curl_exec($curl_handle);
        curl_close($curl_handle);
        return response($res);

    }

    private function YoutubeSearch_proc($search_query)
    {
        $curl_handler = curl_init();
        $encodedSearch = curl_escape($curl_handler, $search_query);
        $yt_url_search = "https://www.googleapis.com/youtube/v3/search?part=snippet&maxResults=12&q={$encodedSearch}&type=video&key=KEY";
        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handler, CURLOPT_URL, $yt_url_search);
        $res = curl_exec($curl_handler);
        curl_close($curl_handler);

        return response($res);
    }

    public function search_content(Request $request)
    {
        $validated = $request->validate([
            'service_select' => ['required', 'string', 'max:255'],
            'search_query' => ['required', 'string', 'max:255'],
        ]);
        if ($validated['service_select'] == 'AniList') {
            return $this->AniList_proc($validated['search_query']);
        } else {
            return $this->YoutubeSearch_proc($validated['search_query']);
        }

    }
}
