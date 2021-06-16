@extends('layouts.app')

@section('title', 'ADD NEW MILESTONE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Create A New Milestone</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Create Milestone <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
            <a href="{{ url('/milestones/'.$id.'') }}"><button class="act_btn back_btn"><img title="Back to Submissions Milestones" src="{{ asset('imgs/back_btn.svg') }}"></button></a>
            </span></h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('store_milestone') }}">
                <input type="hidden" class="form-control" value="{{$id}}" id="sid" name="sid">
                    @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    @csrf

                <div class="form-group">
                	<label class="col-form-label">{{ __('Milestone Name') }}:<span>*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="Name"  id="title" required>
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Description') }}:<span>*</span></label>
                    <textarea name="description_milesstone" class="form-control" placeholder="Description">{{ old('description_milesstone') }}</textarea>
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Due Date') }}:<span>*</span></label>
                    <input type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" name="due_date" value="{{ old('due_date') }}" class="form-control datepicker" placeholder="YYYY-MM-DD" id="due_date" required="required">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</div>

@endsection
