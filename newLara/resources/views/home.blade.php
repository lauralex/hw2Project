@extends('layouts.app')
@section('title', 'Home')
@section('home', 'active')
@section('js_scripts')
	<script type="text/javascript">const missing_url = '{{asset('css/Missing-Profile-Photo.png')}}'</script>
    <script type="text/javascript">const get_likers_url = '{{route('get_likers')}}'</script>
    <script type="text/javascript">const like_url = '{{route('store_like')}}'</script>
    <script type="text/javascript">const post_list_url = '{{route('post_list')}}'</script>
    <script defer src="{{asset('js/home.js')}}"></script>
    <link href="{{asset('css/home.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="container">
    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 d-none" id="posts">
    </div>

    <div class="modal fade" id="post_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="post_modal_label">List of likers</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
