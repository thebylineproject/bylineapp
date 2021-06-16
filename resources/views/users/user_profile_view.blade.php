@extends('layouts.app')

@section('title', 'WRITER PROFILE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>WRITER PROFILE</h2>
        </div>
        <div class="sect_wrapper">
        	<div class="row">
            	<div class="col-md-8">
					<form method="POST" action="" enctype="multipart/form-data">
            		<h2 class="offset-md-1"><u>Personal Info.</u></h2>
                     <div class="row form-group">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Profile Picture: ') }}</label>
                        @if($user[0]->profile_pic)
                        <div class="col-md-6">
                            <img src="{{ asset('assets/images/user_profile/') }}/{{ $user[0]->profile_pic }}" width="150"/>
                        </div>
                        @else
                         <div class="col-md-6">
                            <img src="{{ asset('assets/images/user_profile/noimage.png') }}" width="150"/>
                        </div>
                         @endif
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Name: ') }}</label>
                        <div class="col-md-8">
                            {{$user[0]->name}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('E-Mail Address: ') }}</label>
                        <div class="col-md-8">
                            {{$user[0]->email}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('User Name: ') }}</label>
                        <div class="col-md-8">
                            {{$user[0]->username}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Phone Number: ') }}</label>
                        <div class="col-md-8">
                            {{$user[0]->phone}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Bio: ') }}</label>
                        <div class="col-md-8">
                            {{$user[0]->bio}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Facebook Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_fb}}" target="_blank">{{$user[0]->social_fb}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Twitter Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_fb}}" target="_blank">{{$user[0]->social_tw}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Linkedin Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_fb}}" target="_blank">{{$user[0]->social_lk}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Instagram Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_fb}}" target="_blank">{{$user[0]->social_ig}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                      <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('All Submissions: ') }}</label>  
                       <div class="col-md-8"> 
                          @foreach($submissions as $submission)
                          <b> - <a href="{{ url('/edit_submissions/'.$submission->sid) }}">{{ $submission->title }}</a></b></br>
                          @endforeach
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <br>
                        <div class="col-md-12 text-center">
                            <button type="button" onclick="goBack()" class="btn btn-primary">{{ __('Go Back') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4">
            	<!--<h2><u>Financial Info.</u></h2>-->
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script>
	function goBack() {
		window.history.back();
	}
</script>
@endpush