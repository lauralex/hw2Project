@extends('layouts.app')
@section('title', 'Create Post')
@section('create_post', 'active')

@section('js_scripts')
    <script type="text/javascript">const uri = '{{route('search_content')}}'</script>
    <script type="text/javascript">const create_post_url = '{{route('submit_post')}}'</script>
    <script defer src="{{asset('js/create_post.js')}}"></script>
@endsection

@section('content')
    <div class="container">
        <form id="search_form">
            @csrf
            <div class="form-group">
                <label for="service_select">Service</label>
                <select name="service_select" class="form-control" id="service_select" aria-describedby="service_desc">
                    <option selected disabled value="">Choose...</option>
                    <option value="AniList">AniList</option>
                    <option value="GoogleBooks">Youtube Search</option>
                </select>
                <small id="service_desc" class="form-text text-muted">Select a service to use for your post</small>
            </div>
            <div class="form-group">
                <label for="search_query">Search</label>
                <input class="form-control" id="search_query" type="search" name="search_query"
                       aria-describedby="search_desc">
                <small id="search_desc" class="form-text text-muted">Search for something you like</small>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Search</button>
        </form>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 d-none" id="result_list">

        </div>

        <div class="modal fade" id="post_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="modal_form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="post_modal_label">Insert Title</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
