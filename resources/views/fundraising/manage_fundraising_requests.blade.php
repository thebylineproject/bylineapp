@extends('layouts.app')

@section('title', 'MANAGE FUNDRAISING REQUESTS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Fundraising Requests<span class="search_count">{{count($fundraising_requests)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">
            @if(Session::has('message'))
            	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <h4 class="updates_heading">
            
            <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
                <a href="{{ url('/submissions') }}"><button class="act_btn">Back to Submissions</button></a>
            </span></h4>
                  
            <table class="table submiss_table all_submiss display" id="manage_fundraising" style="width:100%; font-size: 14px;">
                <thead>
                    <tr>
                        <th>Submission Title</th>
                        <th>Author</th>
                        <th>Description/Reason</th>
                        <th>Requested Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$fundraising_requests->isEmpty())
                    @foreach($fundraising_requests as $key =>  $value)
                    <tr>
                        <td><b>{{ $value->title }}</b></td>
                        <td><b>{{ $value->user_name }}</b></td>
                        <td>{{ $value->reason }}</td>
                        <td>${{ $value->amount }}</td>
                        <td>{{ $value->status }}</td>
                        <td>
                        	<a href="{{ url('/download/'.$value->expense_report) }}"><button class="act_btn">Expense Report</button></a>
                        	@role('admin')
                            	<a href="{{ url('/fundraising/request_modify/'.$value->frid) }}"><button class="act_btn">Modify</button></a>
                            	<a onclick="request_status('Accepted', '{{ $value->frid }}');" href="javascript:;"><button class="act_btn">Accept</button></a>
                            	<a onclick="request_status('Denied',   '{{ $value->frid }}');" href="javascript:;"><button class="act_btn">Deny</button></a>
                            @endrole
                            @role('editor')
                            	<a href="{{ url('/fundraising/request_modify/'.$value->frid) }}"><button class="act_btn">Modify</button></a>
                            	<a onclick="request_status('Accepted', '{{ $value->frid }}');" href="javascript:;"><button class="act_btn">Accept</button></a>
                            	<a onclick="request_status('Denied',   '{{ $value->frid }}');" href="javascript:;"><button class="act_btn">Deny</button></a>
                            @endrole
                        </td>
                    </tr>
                    @endforeach                    
                    @else
                    <tr>
                        <td colspan="5"><b>No record found</b></td>                       
                    </tr>
                    @endif
                </tbody>
            </table>
          
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script type="text/javascript">
	$(document).ready(function() {
		$('#manage_fundraising').DataTable();
	});
</script>
@endpush