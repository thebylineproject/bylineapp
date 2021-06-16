@extends('layouts.app')

@section('title', 'MANAGE USERS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Manage Users <span class="search_count">{{count($users)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">          
            
            @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif
            <h4 class="updates_heading">All Users <span class="submission_filters_fields text-right"><a href="{{ url('/add_new_user') }}"><button class="act_btn">Add New User</button></a></span></h4>
                <table class="table submiss_table all_submiss display" id="manage_users" style="width:100%; font-size: 14px;">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td><b>{{ $user->name }}</b></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->rolename }}</td>
                        <td>{{date('Y-m-d', strtotime($user->created_at))}}</td>
                        <td>
                            <a href="{{ url('/edit_user/'.$user->id) }}"><button class="act_btn">EDIT</button></a>
                            <a onclick="return confirm('Are you sure you want to detele?')" href="{{ url('/delete_user/'.$user->id) }}"><button class="act_btn">DELETE</button></a>
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
		$('#manage_users').DataTable();
	});
</script>
@endpush
