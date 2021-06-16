@extends('layouts.app')

@section('title', 'ADD NEW SUBMISSION'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Create A New Submission</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Create Submission
                <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
                    <a href="{{ url('/submissions') }}"><button class="act_btn">Back to Submissions</button></a>
                </span>
            </h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('store_submission') }}">
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                <div class="form-group">
                	<label class="col-form-label">{{ __('Title') }}:<span>*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="Title" id="title" required="required">
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Description') }}:<span>*</span></label>
                    <textarea name="description" class="form-control create_submission" placeholder="Submit your story">{{ old('description_milesstone') }}</textarea>
                </div>
				@role('admin')
                    <div class="form-group">
                		<label class="col-form-label">{{ __('Fundraising Goal') }}:</label>
                        <input type="text" name="fundraising_goal" value="{{old('fundraising_goal')}}" class="form-control" placeholder="Fundraising Goal" id="fundraising_goal">
                    </div>
				@endrole
                <div class="form-group">
                	<label class="col-form-label">{{ __('Images') }}:</label>
                    <input style="border: none;padding-left: 0px;" type="file" class="form-control" name="images[]" multiple>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</div>

@endsection