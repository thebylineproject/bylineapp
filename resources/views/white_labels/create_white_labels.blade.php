@extends('layouts.app')

@section('title', 'PUBLISHER SETTINGS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Publisher Settings</h2>
        </div>
        <div class="sect_wrapper">
            <form method="POST" action="{{ route('store_white_labels') }}" enctype="multipart/form-data">
            	<h2 class="publisher_sett_heading"><u>Publisher Settings.</u></h2>
                @csrf
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @php
                	if(!$labels->isEmpty()){
                    	$wid				= $labels[0]->wid;
                    	$logo				= $labels[0]->logo;
                    	$publisher_name		= $labels[0]->publisher_name;
                    	$contact_email		= $labels[0]->contact_email;
                    	$description		= $labels[0]->description;
                    	$publisher_website	= $labels[0]->publisher_website;
                    	$physical_address	= $labels[0]->physical_address;
                    	$contact_info		= $labels[0]->contact_info;
                        $address_1			= $labels[0]->address_1;
                    	$address_2			= $labels[0]->address_2;
                    	$city				= $labels[0]->city;
                    	$state				= $labels[0]->state;
                    	$zip				= $labels[0]->zip;
                        $google_email			= $labels[0]->google_email;
                        $auth_token			= $labels[0]->auth_token;
                    }else{
                    	$wid				= '';
                    	$logo				= '';
                    	$publisher_name		= '';
                    	$contact_email		= '';
                    	$description		= '';
                    	$publisher_website	= '';
                    	$physical_address	= '';
                    	$contact_info		= '';
                    	$address_1			= '';
                    	$address_2			= '';
                    	$city				= '';
                    	$state				= '';
                    	$zip				= '';
                        $google_email		= '';
                        $auth_token			= '';
                    }
                @endphp
                <input type="hidden" class="form-control" value="{{ $wid }}" id="wid" name="wid">
                <input type="hidden" class="form-control" value="{{ $logo }}" id="logo_old" name="logo_old">
                <div class="row form-group">
                    <div class="col">
                    	<label class="col-form-label">{{ __('Publisher Name') }}:<span>*</span> <a class="tool_info" rel=tooltip href="#" data-toggle="tooltip" data-placement="top" title="Publisher Name">?</a></label>
                        <input type="text" class="form-control @error('publisher_name') is-invalid @enderror" id="publisher_name" placeholder="{{ __('Publisher Name') }}" name="publisher_name" value="{{ $publisher_name }}" required autocomplete="publisher_name" autofocus>
                        @error('publisher_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('Contact Email') }}:<span>*</span> <a class="tool_info" href="#" data-toggle="tooltip" data-placement="top" title="Contact Email">?</a></label>
                        <input type="text" name="contact_email" class="form-control" value="{{$contact_email}}" placeholder="Contact Email">
                        @error('contact_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Description') }}:<span>*</span></label>
                        <textarea name="description" class="form-control create_submission" placeholder="Description" >{{$description}}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Publisher Website') }}:<span>*</span> <a href="#" class="tool_info" data-toggle="tooltip" data-placement="top" title="Publisher Website">?</a></label>
                        <input type="text" name="publisher_website" class="form-control" value="{{$publisher_website}}" placeholder="Publisher Website" >
                        @error('publisher_website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col"> 
                        <label class="col-form-label">{{ __('Google Email Account') }}:<span>*</span> <a href="#" class="tool_info" data-toggle="tooltip" data-placement="top" title="Google Email Account">?</a></label>
                        <input type="text" name="google_email" class="form-control" value="{{$google_email}}" placeholder="Google Email Account" >
                        @error('google_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Auth Token') }}:<span>*</span> <a href="#" class="tool_info" data-toggle="tooltip" data-placement="top" title="Auth Token">?</a></label>
                        <input type="text" id="auth_token" name="auth_token" class="form-control" value="{{$auth_token}}" placeholder="Auth Token" readonly="readonlyy">
                        @error('auth_token')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                    	<label class="col-form-label">You can generate token from this function:</label><br />
                    	<button type="button" class="btn btn-primary" onclick="generateToken();">{{ __('Generate Token') }}</button>
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Physical Address') }}:</label>
                        <input type="text" name="physical_address" class="form-control" value="{{$physical_address}}" placeholder="Physical Address">
                        @error('physical_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Address Line 1') }}:<span>*</span></label>
                        <input type="text" name="address_1" class="form-control" value="{{$address_1}}" placeholder="Address Line 1" >
                        @error('address_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('Address Line 2') }}:</label>
                        <input type="text" name="address_2" class="form-control" value="{{$address_2}}" placeholder="Address Line 2">
                        @error('address_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('City') }}:</label>
                        <input type="text" name="city" class="form-control" value="{{$city}}" placeholder="City" >
                        @error('city')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('State') }}:</label>
                        <input type="text" name="state" class="form-control" value="{{$state}}" placeholder="State">
                        @error('state')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Contact Information') }}:</label>
                        <input type="text" name="contact_info" class="form-control" value="{{$contact_info}}" placeholder="Contact Information">
                        @error('contact_info')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('Zip') }}:</label>
                        <input type="text" name="zip" class="form-control" value="{{$zip}}" placeholder="Zip">
                        @error('zip')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                @if($logo)
                	<div class="row form-group">
                        <div class="col">
                            <label class="col-form-label">{{ __('Logo') }}:<span>*</span></label>
                            <input type="file" class="form-control" name="logo" />
                            @error('logo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col"><img src="{{ asset('imgs') }}/{{ $logo }}" width="150"/></div>
                        <!--<div class="col"><img src="{{ asset('assets/images/') }}/{{ $logo }}" width="150"/></div>-->
                    </div>
                @else
                	<div class="row form-group">
                        <div class="col">
                            <label class="col-form-label">{{ __('Logo') }}:</label>
                            <input type="file" class="form-control" name="logo" />
                            @error('logo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col"><img src="{{ asset('assets/images/user_profile/noimage.png') }}" width="150"/></div>
                    </div>
				@endif
                
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-center">
                        <br>
                        <button type="submit" class="btn btn-primary">{{ __('Save Settings') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<style>.invalid-feedback{display:inline-block;}</style>
@endsection
@push('scripts')
	<script type='text/javascript'>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
		});
		function generateToken(){
			var result           = '';
			var length           = '64';
			var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
			var charactersLength = characters.length;
			for ( var i = 0; i < length; i++ ) {
				result += characters.charAt(Math.floor(Math.random() * charactersLength));
			}
			$('#auth_token').val(result);
			
			var copyText = document.getElementById("auth_token");
			copyText.select();
			copyText.setSelectionRange(0, 99999)
			document.execCommand("copy");
			alert("Copied the token: " + copyText.value);
		}
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush