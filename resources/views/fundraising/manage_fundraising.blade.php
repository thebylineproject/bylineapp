@extends('layouts.app')

@section('title', 'MANAGE FUNDS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Funds Raised <span class="search_count">{{count($fundraising)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">
            @if(Session::has('message'))
            	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <h4 class="updates_heading manage_fundraising_heading"><a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}">{{ $submissions[0]->title }}</a><br />
            <span class="small"><a href="{{ url('/user/'.$submissions_author[0]->id) }}">{{ $submissions_author[0]->name }}</a></span>
            
            <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields manage_fundraising_btns text-right">
            <div><a href="{{ url('/submissions') }}"><button class="act_btn back_btn"><img title="Back to Submissions" src="{{ asset('imgs/back_btn.svg') }}"></button></a>
            </div>
                <a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}"><button class="act_btn border_btn">View Submission</button></a>
                <!--<a href="create/{{$id}}"><button class="act_btn">Add Funds</button></a>-->
            </span></h4>
                  
            <table class="table submiss_table all_submiss display" id="manage_fundraising" style="width:100%; font-size: 14px;">
                <thead>
                    <tr>
                        <th>Funder</th> 
                        <th>Amount</th>                              
                        <th>Action</th>  
                    </tr>
                </thead>
                <tbody>
                    @if(!$fundraising->isEmpty())
                    @foreach($fundraising as $key =>  $value)
                    <tr>
                        <td><b>{{ $value->funder_name }}</b></td> 
                        <td><b>${{ $value->amount }}</b></td>                           
                        <td>
                            <a href="{{ url('/edit_fundraising/'.$value->fid) }}"><button class="act_btn">EDIT</button></a>
                            <a onclick="return confirm('Are you sure you want to detele?')" href="{{ url('/delete_fundraising/'.$value->fid) }}"><button class="act_btn">DELETE</button></a>                            
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