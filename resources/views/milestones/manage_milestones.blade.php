@extends('layouts.app')

@section('title', 'MANAGE SUBMISSIONS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Manage Milestones <span class="search_count">{{count($submission_milestone)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">
            @if(Session::has('message'))
            	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <h4 class="updates_heading manage_milestone_heading"><a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}">{{ $submissions[0]->title }}</a><br />
            <span class="small" style="font-size: 16px;"><a href="{{ url('/user/'.$submissions_author[0]->id) }}">{{ $submissions_author[0]->name }}</a></span>
            
                <span style="width: 50%;" class="submission_filters_fields text-right">
                    <span style="width: 100% !important" class="submission_filters_fields manage_milestone_btns text-right">
                    <div>
                    <a href="{{ url('/submissions') }}"><button class="act_btn back_btn"><img src="{{ asset('imgs/back_btn.svg') }}"></button></a>
                    </div>
                    <a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}"><button class="act_btn border_btn">View Submission</button></a>
                    
                    @role('admin')
                    <a href="create/{{$id}}"><button class="act_btn border_btn">Add New Milestone</button></a>
                    @endrole
                </span>
            </h4>
            
            <div class="col-md-10 manage_milestone_timeline">
            	<h4>Milestones</h4>
                <ul class="timeline">    
                    @if(!empty($submission_milestone))
                        @foreach($submission_milestone as $milestone)
                        @php
                            $user_info			= get_user_info($milestone['user_id']);
                        @endphp
                            <li class="{{$milestone['active']}}">
                                <a href="javascript:;">{{ $milestone['title'] }}</a>
                                <a href="javascript:;" class="float-right">{{ date('d F, Y', strtotime($milestone['due_date'])) }}</a> <small style="color:#6e6e6e">Created by {{ $user_info[0]->name }}</small>
                                <p>{{ \Illuminate\Support\Str::limit(strip_tags($milestone['description']), 200, $end='...') }}</p>
                                <p><a href="" data-toggle="modal" data-target="#exampleModal_{{ $milestone['milestone_id'] }}">Edit Milestone</a></p>
                            </li>
                            <div class="modal fade" id="exampleModal_{{ $milestone['milestone_id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        	<h5 class="modal-title" id="exampleModalLabel">Update Milestone "{{$milestone['title']}}"</h5>
                                        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                        	<form enctype="multipart/form-data" method="POST" action="{{ route('update_milestone') }}">
                                                <input type="hidden" class="form-control" value="{{$submissions[0]->sid}}" id="sid" name="sid">  
                                                <input type="hidden" class="form-control" value="{{$milestone['milestone_id']}}" id="milestone_id" name="milestone_id">
                                                @csrf
                                                <div class="form-group">
                                                	<label class="col-form-label">{{ __('Milestone Title') }}:<span>*</span></label>
                                                    <input type="text" name="title" value="{{$milestone['title']}}" class="form-control" placeholder="Milestone Title" id="title" required>
                                                </div>
                                                <div class="form-group">
                                                	<label class="col-form-label">{{ __('Description') }}:<span>*</span></label>
                                                    <textarea name="description_milesstone" class="form-control" placeholder="Description" required> {{$milestone['description']}} </textarea>
                                                </div>
                                                <div class="form-group">
                                                	<label class="col-form-label">{{ __('Due Date') }}:<span>*</span></label>
                                                    <input type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" value="{{$milestone['due_date']}}" name="due_date" class="form-control datepicker" placeholder="YYYY-MM-DD" id="due_date" required>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        	<button type="submit" class="btn btn-primary">Update changes</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <li class="sub_started">
                            <a href="javascript:;" style="color:#6e6e6e">Submission Created</a>
                            <a href="javascript:;" class="float-right">{{ date('d F, Y', strtotime($submissions[0]->created_at)) }}</a>
                        </li>
                    @else
                        <li>
                            <a href="javascript:;"></a>
                            <a href="javascript:;" class="float-right"></a>
                            <p>No Milestones For You!</p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
	ul.timeline {
		list-style-type: none;
		position: relative;
	}
	ul.timeline:before {
		content: ' ';
		background: #d4d9df;
		display: inline-block;
		position: absolute;
		left: 29px;
		width: 2px;
		height: 96%;
		z-index: 400;
	}
	ul.timeline > li {
		margin: 20px 0;
		padding-left: 20px;
	}
	ul.timeline > li:before {
		content: ' ';
		background: white;
		display: inline-block;
		position: absolute;
		border-radius: 50%;
		border: 3px solid #22c0e8;
		left: 20px;
		width: 20px;
		height: 20px;
		z-index: 400;
	}
	ul.timeline > li.active:before {
		content: ' ';
		background: white;
		display: inline-block;
		position: absolute;
		border-radius: 50%;
		border: 3px solid #F00;
		left: 20px;
		width: 20px;
		height: 20px;
		z-index: 400;
	}
	ul.timeline > li.sub_started:before {
		content: ' ';
		background: white;
		display: inline-block;
		position: absolute;
		border-radius: 50%;
		border: 3px solid #6e6e6e;
		left: 20px;
		width: 20px;
		height: 20px;
		z-index: 400;
	}
</style>