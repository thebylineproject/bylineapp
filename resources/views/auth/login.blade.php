@extends('layouts.app')

@section('title', 'LOGIN'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <div class="full_width_container">
        <div class="half_Sec_left">
            <div class="container">
                <h3 id="tab_name">Login</h3>
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="imgs/dark_logo.png" title="{{ config('app.app_email_title') }}">
                </a>
            </div>
        </div>
        <div class="half_Sec_right">
            <div class="container">
                <div class="row text-center" style="margin-top:0px;">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        @if(Request::get('action') == 'verify')
                            <strong style="color:green;">Signup was successful. You will receive an email confirmation link.</strong>
                        @endif
                        @if(Request::get('action') == 'verified')
                            <strong style="color:green;">Email address verified successfully.</strong>
                        @endif
                        @if(Request::get('action') == 'verifyfail')
                            <strong style="color:red;">Invalid email verification code.</strong>
                        @endif
                    </div>
                    <div class="col-md-2"></div>
                </div>
                <div class="row text-center">
                    <div class="login_rigster_logo">
                        <img src="{{ asset('imgs') }}/{{ config('app.app_footer_logo') }}" title="{{ config('app.app_email_title') }}">
                    </div>
                    <div class="col-md-12 tabs_login_register">
                        <nav>
                            <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true">Login</a>
                                <a class="nav-item nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false">Register</a>
                            </div>
                        </nav>
                        <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
                            	<div class="irp_login_wrapper" style="margin-top:40px;">
                                    <div class="irp_login">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                <span class="field_icon"><i class="fa fa-envelope"></i></span><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder='Email'>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                    <strong style="color:red;">{{ Request::get('error') }}</strong>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                <span class="field_icon"><i class="fa fa-lock"></i></span> <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <div class="forget_pass" >
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="form-group row mb-0">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Login With Email') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="vl">
                                                <span class="vl-innertext">Or feel free to...</span>
                                            </div>
                                            <div class="login_with">
                                                <a href="{{ url('auth/google') }}" style="margin-top: 20px" class="google btn"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png"> Continue With Google </a>
                                                <a href="{{ url('redirect') }}" style="margin-top: 20px;" class="fb btn">
                                                    <i class="fa fa-facebook-square fa-fw"></i> Continue With Facebook
                                                </a>
                                            </div>
                                        </form>
                                    </div>
                    			</div>
							</div>
							<div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
								<div class="text-left">
                                	<div class="card-body">
                                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row form-group">
                                                <div class="register_with col">
                                                    <a href="{{ url('auth/google') }}" class="google btn"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png"> Continue With Google
                                                    </a>
                                                </div>
                                                <div class="register_with col">
                                                    <a href="{{ url('redirect') }}" class="fb btn">
                                                    <i class="fa fa-facebook-square fa-fw"></i> Continue With Facebook
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('Name') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-id-card"></i></span><input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ __('Name') }}" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                                    @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('E-Mail') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-envelope"></i></span><input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" >
                                                    @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row form-groupp">
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('Password') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-lock"></i></span><input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="{{ __('Password') }}" name="password" value="{{ old('password') }}" required autocomplete="new-password" autofocus>
                                                    
                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('Confirm Password') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-lock"></i></span><input id="password_confirm" type="password" class="form-control @error('password-confirm') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="email" placeholder="{{ __('Confirm Password') }}" >
                                                </div>
                                            </div>
                                            <div class="row"><div class="col"><small id="passwordError" class="form-text text-muted">Password must be 10 characters in length and contain uppercase, lowercase, numeric and special characters.</small></div></div>
                                            <div class="row form-group">
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('Username') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-user"></i></span><input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="{{ __('User Name') }}" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                                    @error('username')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('Phone') }}:</label>
                                                    <span class="field_icon"><i class="fa fa-phone"></i></span><input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="phone" placeholder="{{ __('Phone Number') }}">
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>                            
                                            </div>
                                            <div class="row form-group">
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('City') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-map-marker"></i></span><input type="text" class="form-control @error('city') is-invalid @enderror" id="city" placeholder="{{ __('City') }}" name="city" value="{{ old('city') }}" required autocomplete="city" autofocus>
                                                    @error('city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col"><span class="required_icon">*</span>
                                                    <label class="col-form-label">{{ __('State') }}:<span>*</span></label>
                                                    <span class="field_icon"><i class="fa fa-map-marker"></i></span><input type="text" class="form-control @error('state') is-invalid @enderror" name="state" value="{{ old('state') }}" autocomplete="state" placeholder="{{ __('State') }}">
                                                    @error('state')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>                            
                                            </div>
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('Bio') }}:</label>
                                                    <span class="field_icon"><i class="fa fa-wpforms"></i></span><textarea class="form-control" rows="5" name="bio" placeholder="{{ __('Bio') }}">{{ old('bio') }}</textarea>
                                                </div>
                                            </div>                        
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('Facebook Profile') }}:</label>
                                                    <span class="field_icon"><i class="fa fa-facebook"></i></span><input type="text" class="form-control @error('social_fb') is-invalid @enderror" placeholder="{{ __('Facebook Profile') }}" name="social_fb" value="{{ old('social_fb') }}" autocomplete="social_fb" autofocus>
                                                    @error('social_fb')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('Twitter Profile') }}:</label>
                                                    <span class="field_icon"><i class="fa fa-twitter"></i></span><input type="text" class="form-control @error('social_tw') is-invalid @enderror" placeholder="{{ __('Twitter Profile') }}" name="social_tw" value="{{ old('social_tw') }}" autocomplete="social_tw" autofocus>
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
                                                    <span class="field_icon"><i class="fa fa-instagram"></i></span><input type="text" class="form-control @error('social_ig') is-invalid @enderror" placeholder="{{ __('Instagram Profile') }}" name="social_ig" value="{{ old('social_ig') }}" autocomplete="social_ig" autofocus>
                                                    @error('social_ig')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                                <div class="col">
                                                    <label class="col-form-label">{{ __('Linkedin Profile') }}:</label>
                                                    <span class="field_icon"><i class="fa fa-linkedin"></i></span><input type="text" class="form-control @error('social_lk') is-invalid @enderror" placeholder="{{ __('Linkedin Profile') }}" name="social_lk" value="{{ old('social_lk') }}" autocomplete="social_lk" autofocus>
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
                                            <div class="row form-group">
                                                <div class="col">
                                                    <input type="checkbox" class="" name="terms" required="required" /> By completing registration, I agree that I have read and accept the <a href="{{ route('terms') }}" target="_blank">Terms &amp; Conditions</a>
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
                    </div>
				</div>
			</div>
        </div>
    </div>
<style>
/* add appropriate colors to fb, twitter and google buttons */
.fb {
  background-color: #3B5998;
  color: white;
}
.fb:hover, .google:hover {
  color: white;
}
label.col-form-label {
    display: none;
}
.google {
  background-color: #dd4b39;
  color: white;
}
.footer_logo{
	display:none;
}

/* style the submit button */
input[type=submit] {
  background-color: #4CAF50;
  color: white;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}
.nav_icon{
    display:none;
}
.tabs_login_register input[type="file"] {
    background: transparent !important;
    height: auto !important;
    padding-left: 0px;
    border-radius: 0px !important;
}
.fa.fa-facebook-square.fa-fw {
    color: #4267B2 !important;
}
</style>

@endsection

@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#nav-login-tab').on('click', function () {
			$('#tab_name').html('LOGIN');
		});
		$('#nav-register-tab').on('click', function () {
			$('#tab_name').html('REGISTER');
		});
	});
</script>
@endpush