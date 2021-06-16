@extends('layouts.app')

@section('title', 'FUNDRAISING REQUEST'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Fundraising Request</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Fundraising Request For Submission<span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
            <a href="{{ url('/submissions/') }}">><img title="Back to Submissions" src="{{ asset('imgs/back_btn.svg') }}"></button></a>
            </span></h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('request_submit') }}">
            	<label for="name" class="col-md-12 col-form-label" style="font-size: 28px; padding: 0px;"><a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}">{{$submissions[0]->title}}</a></label>
                <span class="small"><a href="{{ url('/user/'.$submissions_author[0]->id) }}">{{ $submissions_author[0]->name }}</a></span>
                <input type="hidden" class="form-control" value="{{$id}}" id="sid" name="sid">               
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                <div class="form-group">
                 	<label class="col-form-label">{{ __('Description/Reason') }}:<span>*</span></label>
                    <textarea class="form-control" rows="5" name="reason" placeholder="{{ __('Description/Reason') }}" required="required">{{ old('reason') }}</textarea>
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Amount Requested') }}:<span>*</span></label>
                    <input type="text" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="Amount" id="amount" required>
                    <input type="hidden" name="reference_id" value="{{ rand(0, 10000000000) }}">
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Expense Report (PDF or Excel file only)') }}:<span>*</span></label>
                    <input type="file" class="form-control" name="images" />
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form> 
        </div>
    </div>
</div>

@endsection
