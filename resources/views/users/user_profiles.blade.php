@extends('layouts.app')

@section('title', 'WRITERS PROFILE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Writers Profiles<span class="search_count">{{count($users)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">          
            
            @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
            <h4 class="updates_heading">All Writers Profiles</h4>
            <table class="table submiss_table all_submiss display" id="user_profiles" style="width:100%">
                <thead>
                    <tr>
                        <th>Writer Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><b>{{ $user->name }}</b></td>
                        <td>
                            <a href="{{ url('/user/'.$user->id) }}"><button class="act_btn">View Profile</button></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!--<div class="text-center">
                <a class="load_mor" href="#">Load More...</a>
            </div>-->
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
	$(document).ready(function() {
		$('#user_profiles').DataTable();
	});
</script>
@endpush