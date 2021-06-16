@extends('layouts.app')

@section('title', 'MY PROFILE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>MY PROFILE</h2>
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
                            <a href="{{$user[0]->social_tw}}" target="_blank">{{$user[0]->social_tw}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Linkedin Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_lk}}" target="_blank">{{$user[0]->social_lk}}</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-lg-4 col-form-label text-md-right">{{ __('Instagram Profile: ') }}</label>
                        <div class="col-md-8">
                            <a href="{{$user[0]->social_ig}}" target="_blank">{{$user[0]->social_ig}}</a>
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
                        <div class="col-md-6 text-center"></div>
                        <div class="col-md-6 text-center">
                            <br>
                            <a href="{{ route('update_profile') }}"><button type="button" class="btn btn-primary">{{ __('Edit Profile') }}</button></a>
                        </div>
                    </div>
                </form>
            	</div>
                <div class="col-lg-4">
                    <h2><u>Financial Info.</u></h2>
                    @if($user[0]->paypal_btn)
                    <div class="form-group row">
                        <label for="name" class="col-md-12 col-form-label"><u>{{ __('PayPal Button: ') }}</u></label>
                        <div class="col-md-12" style="word-break: break-word;">
                        	{!! $user[0]->paypal_btn !!}
                        </div>
                    </div>
                    @endif
                    
                    @if($user[0]->coinbase_btn)
                    <div class="form-group row">
                        <label for="name" class="col-md-12 col-form-label"><u>{{ __('Coinbase Commerce Button: ') }}</u></label>
                        <div class="col-md-12" style="word-break: break-word;">
                        	{!! $user[0]->coinbase_btn !!}
                        </div>
                    </div>
                    @endif
                </div>
        	</div>
    	</div>
    </div>
</div>
@endsection
@push('scripts')
	<!--<script src="https://www.paypal.com/sdk/js?client-id=<?php #echo $user[0]->client_id;?>"></script>-->
    <script>
		/*paypal.Buttons({
			style: {
				layout:  'horizontal',
				color:   'gold',//black
				shape:   'rect',
				label:   'paypal',//paypal
				size:    '25',
				tagline: false
			}
		}).render('#paypal-button-container');*/
    </script>
	<script>
        function goBack() {
            window.history.back();
        }
    </script>
@endpush