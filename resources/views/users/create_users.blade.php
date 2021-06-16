@extends('layouts.app')

@section('title', 'ADD NEW USER'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
    <div class="row justify-content-center" style="margin-top: 30px;">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add New User') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('create_user') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Name') }}:<span>*</span></label>
                            	<input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('E-Mail') }}:<span>*</span></label>
                            	<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" >
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Password') }}:<span>*</span></label>
                            	<input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" required autocomplete="new-password" autofocus>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('Confirm Password') }}:<span>*</span></label>
                            	<input id="password_confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="email" placeholder="{{ __('Confirm Password') }}" >
                            </div>
                        </div>
                        <div class="row"><div class="col"><small id="passwordError" class="form-text text-muted">Password must be 10 characters in length and contain uppercase, lowercase, numeric and special characters.</small></div></div>
                        <div class="row form-group">
                        	<div class="col">
                    			<label class="col-form-label">{{ __('Username') }}:<span>*</span></label>
                            	<input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="{{ __('User Name') }}" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('Role') }}:<span>*</span></label>
                            	<select class="form-control" name="role" id="role">
                                    @foreach($roles as $role)
                                     <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach                   
								</select>
                            </div>                            
                        </div>
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('City') }}:<span>*</span></label>
                            	<input type="text" class="form-control @error('city') is-invalid @enderror" id="city" placeholder="{{ __('City') }}" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('State') }}:<span>*</span></label>
                            	<input id="state" type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" required autocomplete="state" placeholder="{{ __('State') }}" >
                                @error('state')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Phone') }}:</label>
                            	<input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" placeholder="{{ __('Phone Number') }}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Bio') }}:</label>
                            	<textarea class="form-control" rows="5" name="bio" placeholder="{{ __('Bio') }}">{{ old('bio') }}</textarea>
                            </div>
                        </div>                        
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Facebook Profile') }}:</label>
                            	<input type="text" class="form-control @error('social_fb') is-invalid @enderror" placeholder="{{ __('Facebook Profile') }}" name="social_fb" value="{{ old('social_fb') }}" autocomplete="social_fb" autofocus>
                                @error('social_fb')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('Twitter Profile') }}:</label>
                            	<input type="text" class="form-control @error('social_tw') is-invalid @enderror" placeholder="{{ __('Twitter Profile') }}" name="social_tw" value="{{ old('social_tw') }}" autocomplete="social_tw" autofocus>
                                @error('social_tw')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Instagram Profile') }}:</label>
                            	<input type="text" class="form-control @error('social_ig') is-invalid @enderror" placeholder="{{ __('Instagram Profile') }}" name="social_ig" value="{{ old('social_ig') }}" autocomplete="social_ig" autofocus>
                                @error('social_ig')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="col">
                    			<label class="col-form-label">{{ __('Linkedin Profile') }}:</label>
                            	<input type="text" class="form-control @error('social_lk') is-invalid @enderror" placeholder="{{ __('Linkedin Profile') }}" name="social_lk" value="{{ old('social_lk') }}" autocomplete="social_lk" autofocus>
                                @error('social_lk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>                        
                        <div class="row form-group">
                            <div class="col">
                    			<label class="col-form-label">{{ __('Profile Photo') }}:</label>
                            	<input type="file" class="form-control" name="profile_pic" />
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12 text-center">
                                <button type="submit" id="submit_button" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
	<script type="text/javascript">
        $(document).ready(function() {
            $('#password, #password_confirm').on('keyup', function () {
				var lCaseAlphabetic = /^(?=.*[a-z])/;
				var uCaseAlphabetic = /^(?=.*[A-Z])/;
				var nCaseAlphabetic = /^(?=.*[0-9])/;
				var nCaseAlphabetic = /^(?=.*[0-9])/;
				var sCase = /^(?=.*[@!#$%^&+=]).*$/;
				var msg1 = '';
				var msg2 = '';
				var msg3 = '';
				var msg4 = '';
				var msg5 = '';
				var count = 0
				if (lCaseAlphabetic.test($(this).val()) == false) {
					msg1 = '1 lowercase alphabetic character, ';
					count = 1
				}
				if (uCaseAlphabetic.test($(this).val()) == false) {
					msg2 = '1 uppercase alphabetic character, ';
					count = 1
				}
				if (nCaseAlphabetic.test($(this).val()) == false) {
					msg3 = '1 numeric, ';
					count = 1
				}
				if (sCase.test($(this).val()) == false) {
					msg4 = '1 special character ';
					count = 1
				}
				if (this.value.length < 10) {
					msg5 = ' of length 10. ';
					count = 1
				}
		
				if (count == 1) {
					$('#passwordError').html('<span style="color:red;">Password must have at least ' + msg1 + ' ' + msg2 + ' ' + msg3 + ' ' + msg4 + ' ' + msg5 + '</span>');					
					$('#submit_button').prop('disabled', true);
				} else {
					$('#passwordError').html('');					
					$('#submit_button').prop('disabled', false);
				}
			});
        });
    </script>
@endpush