@extends('layouts.app')

@section('title', 'UPDATE FUNDS '.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Update Funds</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Update Funds <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important" class="submission_filters_fields text-right"><a href="{{ url('/fundraising/'.$fundraising[0]->submission_id.'') }}"><button class="act_btn back_btn"><img title="Back to Submission Funds" src="{{ asset('imgs/back_btn.svg') }}"></button></a></span></h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('update_fundraising') }}">
                <input type="hidden" class="form-control" value="{{$fundraising[0]->submission_id}}" id="sid" name="sid">  
                <input type="hidden" class="form-control" value="{{$fundraising[0]->fid}}" id="fid" name="fid"> 
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                <div class="form-group">
                	<label class="col-form-label">{{ __('Funder Name') }}:<span>*</span></label>
                    <input type="text" name="funder_name" value="{{$fundraising[0]->funder_name}}" class="form-control" placeholder="Funder Name" id="funder_name" required>
                </div>
                 <div class="form-group">
                 	<label class="col-form-label">{{ __('Amount') }}:<span>*</span></label>
                    <input type="text" name="amount" value="{{$fundraising[0]->amount}}" class="form-control" placeholder="Amount" id="amount" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form> 
        </div>
    </div>
</div>

@endsection
