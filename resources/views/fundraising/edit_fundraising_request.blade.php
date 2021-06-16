@extends('layouts.app')

@section('title', 'FUNDRAISING REQUEST UPDATE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Fundraising Request Update</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Fundraising Request For Submission<span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right">
            <a href="{{ url('/fundraising/requests_history/') }}"><button class="act_btn">Back to Fundraising Requests</button></a>
            </span></h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('request_submit_update') }}">
            	<label for="name" class="col-md-12 col-form-label" style="font-size: 28px; padding: 0px;"><a href="{{ url('/edit_submissions/'.$submissions[0]->sid) }}">{{$submissions[0]->title}}</a></label>
                <span class="small"><a href="{{ url('/user/'.$author[0]->id) }}">{{ $author[0]->name }}</a></span>
                <input type="hidden" class="form-control" value="{{$id}}" id="frid" name="frid">               
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                <div class="form-group">
                 	<label class="col-form-label">{{ __('Description/Reason') }}:<span>*</span></label>
                    <textarea class="form-control" rows="5" name="reason" placeholder="{{ __('Description/Reason') }}" required="required">{{$fundraising[0]->reason}}</textarea>
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Amount Requested') }}:<span>*</span></label>
                    <input type="text" name="amount" value="{{$fundraising[0]->amount}}" class="form-control" placeholder="Amount" id="amount" required>
                	<input type="hidden" class="form-control" value="{{$fundraising[0]->expense_report}}" id="expense_report" name="expense_report"> 
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Expense Report (PDF or Excel file only. Leave blank if you dont want to update report)') }}:</label>
                    <input type="file" class="form-control" name="images" />
                </div>
                <button type="submit" class="btn btn-primary">Submit Request</button>
            </form> 
        </div>
    </div>
</div>

@endsection
