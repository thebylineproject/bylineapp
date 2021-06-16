@extends('layouts.app')

@section('title', 'Update MILESTONE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Update Milestone</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Update Milestone <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
            <a href="{{ url('/milestones/'.$milestones[0]->submission_id.'') }}"><button class="act_btn">Back to Submissions Milestones</button></a>
            </span></h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('update_milestone') }}">
                <input type="hidden" class="form-control" value="{{$milestones[0]->submission_id}}" id="sid" name="sid">  
                <input type="hidden" class="form-control" value="{{$milestones[0]->milestone_id}}" id="milestone_id" name="milestone_id"> 
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf

                <div class="form-group">
                    <input type="text" name="title" value="{{$milestones[0]->title}}" class="form-control" placeholder="Name" id="title" required>
                </div>
                <div class="form-group">
                    <textarea name="description_milesstone"  class="form-control" placeholder="Description"> {{$milestones[0]->description}} </textarea>
                </div>

                <div class="form-group">
                    <input type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" value="{{$milestones[0]->due_date}}" name="due_date" class="form-control datepicker" placeholder="YYYY-MM-DD" id="due_date">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</div>

@endsection


