@extends('layouts.app')
@section('title', 'Search People')
@section('search_users', 'active')

@section('js_scripts')
	<script type="text/javascript">const missing_url = '{{asset('css/Missing-Profile-Photo.png')}}'</script>
	<script type="text/javascript">const root_url = '{{route('root')}}'</script>
    <script type="text/javascript">const search_user_url = '{{route('search_user')}}'</script>
    <script type="text/javascript">const follow_user_url = '{{route('follow_user')}}'</script>
    <script type="text/javascript">const search_all_users_url = '{{route('search_all_users')}}'</script>
    <script defer src="{{asset('js/search_people.js')}}"></script>

@endsection

@section('content')

    <div class="container">
        <form id="search_user" class="mb-4">
            <div class="form-group">
                <label for="search_user_box">Insert a username you want to search</label>
                <input type="search" class="form-control" id="search_user_box" name="searchedUser">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
            <button type="button" id="search_all" class="btn btn-primary">Search all</button>
        </form>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 d-none">

        </div>

        <div class="modal fade" id="follow_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="modal_form">
                        <div class="modal-header">
                            <h5 class="modal-title" id="follow_modal_label"></h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
