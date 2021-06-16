@extends('layouts.app')

@section('title', 'UPDATE PROFILE'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>UPDATE PROFILE</h2>
        </div>
        <div class="sect_wrapper">
        	<form method="POST" action="{{ route('update_my_profile') }}" enctype="multipart/form-data">
            	<h2 class=""><u>Personal Info.</u></h2>
                <input type="hidden" class="form-control" value="{{$user[0]->id}}" id="uid" name="uid">
                <input type="hidden" class="form-control" value="{{$user[0]->profile_pic}}" id="profile_pic_old" name="profile_pic_old">
                @csrf
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                <div class="row form-group">
                    <div class="col">
                    	<label class="col-form-label">{{ __('Name') }}:<span>*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ __('Name') }}" name="name" value="{{$user[0]->name}}" required autocomplete="name" autofocus>
                    </div>
                    <div class="col">
                    	<label class="col-form-label">{{ __('E-Mail') }}:<span>*</span></label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$user[0]->email}}" required autocomplete="email" placeholder="{{ __('E-Mail Address') }}" disabled="disabled">
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                    	<label class="col-form-label">{{ __('Username') }}:<span>*</span></label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="{{ __('User Name') }}" name="username" value="{{ $user[0]->username }}" required autocomplete="username" autofocus>
                    </div>
                    <div class="col">
                    	<label class="col-form-label">{{ __('Phone') }}:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user[0]->phone }}" autocomplete="phone" placeholder="{{ __('Phone Number') }}" >
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                    	<label class="col-form-label">{{ __('City') }}:<span>*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" placeholder="{{ __('City') }}" name="city" value="{{$user[0]->city}}" required autocomplete="city" autofocus>
                    </div>
                    <div class="col">
                    	<label class="col-form-label">{{ __('State') }}:<span>*</span></label>
                        <input type="text" id="state" class="form-control @error('state') is-invalid @enderror" name="state" value="{{$user[0]->state}}" required autocomplete="state" placeholder="{{ __('State') }}">
                    </div>
                </div>
                @if($user[0]->profile_pic)
                	<div class="row form-group">
                        <div class="col edit_user_profile_photo">
                            <label class="col-form-label ">{{ __('Profile Photo') }}:</label>
                            <input type="file" class="form-control" name="profile_pic" />
                        </div>
                        <div class="col"><img src="{{ asset('assets/images/user_profile/') }}/{{ $user[0]->profile_pic }}" width="150"/></div>
                    </div>
                @else
                	<div class="row form-group">
                        <div class="col edit_user_profile_photo">
                            <label class="col-form-label">{{ __('Profile Photo') }}:</label>
                            <input type="file" class="form-control" name="profile_pic" />
                        </div>
                        <div class="col edit_user_profile_photo"><img src="{{ asset('assets/images/user_profile/noimage.png') }}" width="150"/></div>
                    </div>
				@endif
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Bio') }}:</label>
                        <textarea class="form-control" rows="5" name="bio" id="user_bio" onkeyup="countChar(this, '240')" placeholder="{{ __('Bio') }}">{{ $user[0]->bio }}</textarea>
                        <div id="char_count"><span id="charNum"></span> Character(s) Remaining</div>
                    </div>
                </div>
                <hr /><h2 class=""><u>Social Profiles.</u></h2>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Facebook Profile') }}:</label>
                        <input type="text" class="form-control @error('social_fb') is-invalid @enderror" placeholder="{{ __('Facebook Profile') }}" name="social_fb" value="{{ $user[0]->social_fb }}" autocomplete="social_fb" autofocus>
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('Twitter Profile') }}:</label>
                        <input type="text" class="form-control @error('social_tw') is-invalid @enderror" placeholder="{{ __('Twitter Profile') }}" name="social_tw" value="{{ $user[0]->social_tw }}" autocomplete="social_tw" autofocus>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col">
                        <label class="col-form-label">{{ __('Instagram Profile') }}:</label>
                        <input type="text" class="form-control @error('social_ig') is-invalid @enderror" placeholder="{{ __('Instagram Profile') }}" name="social_ig" value="{{ $user[0]->social_ig }}" autocomplete="social_ig" autofocus>
                    </div>
                    <div class="col">
                        <label class="col-form-label">{{ __('Linkedin Profile') }}:</label>
                        <input type="text" class="form-control @error('social_lk') is-invalid @enderror" placeholder="{{ __('Linkedin Profile') }}" name="social_lk" value="{{ $user[0]->social_lk }}" autocomplete="social_lk" autofocus>
                    </div>
                </div>
                
                <!--<div class="row form-group">
                        <div class="col">
                            <label class="col-form-label" style="width: 100%;">{{ __('PayPal Client ID') }}: <span class="pull-right"><a target="_blank" href="https://developer.paypal.com/docs/api-basics/manage-apps/#create-or-edit-sandbox-and-live-apps">Learn how to get a PayPal Client ID</a></span></label>
                            <input type="text" class="form-control @error('client_id') is-invalid @enderror" placeholder="{{ __('PayPal Client ID') }}" name="client_id" value="{{ $user[0]->client_id }}" autocomplete="client_id" autofocus>
                        </div>
                    </div>-->
                @role('admin')
                    <hr /><h2 class=""><u>Payment Info.</u></h2>
                    <div class="row form-group">
                        <div class="col">
                            <label class="col-form-label" style="width: 100%;">{{ __('PayPal Button Code') }}: <span class="pull-right"><a target="_blank" href="https://www.paypal.com/donate/buttons">Learn how to generate a PayPal button</a></span></label>
                            <textarea class="form-control" rows="5" name="paypal_btn" placeholder="{{ __('PayPal Button Code') }}">{{ $user[0]->paypal_btn }}</textarea>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col">
                            <label class="col-form-label" style="width: 100%;">{{ __('Coinbase Commerce Button Code') }}: <span class="pull-right"><a target="_blank" href="https://commerce.coinbase.com/docs/#payment-buttons">Learn how to generate a Coinbase button</a></span></label>
                            <textarea class="form-control" rows="5" name="coinbase_btn" placeholder="{{ __('Coinbase Commerce Button Code') }}">{{ $user[0]->coinbase_btn }}</textarea>
                        </div>
                    </div>
                    <input type="hidden" class="form-control" value="{{$user[0]->client_id}}" name="client_id">
                @endrole
                
                @role('editor')
                    @if(!$has_apr_pitch->isEmpty())
                        <hr /><h2 class=""><u>Payment Info.</u></h2>
                        <div class="row form-group">
                            <div class="col">
                                <label class="col-form-label" style="width: 100%;">{{ __('PayPal Button Code') }}: <span class="pull-right"><a target="_blank" href="https://www.paypal.com/donate/buttons">Learn how to generate a PayPal button</a></span></label>
                                <textarea class="form-control" rows="5" name="paypal_btn" placeholder="{{ __('PayPal Button Code') }}">{{ $user[0]->paypal_btn }}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="col-form-label" style="width: 100%;">{{ __('Coinbase Commerce Button Code') }}: <span class="pull-right"><a target="_blank" href="https://commerce.coinbase.com/docs/#payment-buttons">Learn how to generate a Coinbase button</a></span></label>
                                <textarea class="form-control" rows="5" name="coinbase_btn" placeholder="{{ __('Coinbase Commerce Button Code') }}">{{ $user[0]->coinbase_btn }}</textarea>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="{{$user[0]->client_id}}" name="client_id">
                    @else
                    	<div class="row form-group">
                            <div class="col"><label class="col-form-label">Options for payment will be made available upon approval of your first pitch.</label></div>
                        </div>
                        <input type="hidden" class="form-control" value="{{$user[0]->client_id}}" name="client_id">
                        <input type="hidden" class="form-control" value="{{$user[0]->paypal_btn}}" name="paypal_btn">
                        <input type="hidden" class="form-control" value="{{$user[0]->coinbase_btn}}" name="coinbase_btn">
                    @endif
                @endrole
                
                @role('writer')
                    @if(!$has_apr_pitch->isEmpty())
                        <hr /><h2 class=""><u>Payment Info.</u></h2>
                        <div class="row form-group">
                            <div class="col">
                                <label class="col-form-label" style="width: 100%;">{{ __('PayPal Button Code') }}: <span class="pull-right"><a target="_blank" href="https://www.paypal.com/donate/buttons">Learn how to generate a PayPal button</a></span></label>
                                <textarea class="form-control" rows="5" name="paypal_btn" placeholder="{{ __('PayPal Button Code') }}">{{ $user[0]->paypal_btn }}</textarea>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="col-form-label" style="width: 100%;">{{ __('Coinbase Commerce Button Code') }}: <span class="pull-right"><a target="_blank" href="https://commerce.coinbase.com/docs/#payment-buttons">Learn how to generate a Coinbase button</a></span></label>
                                <textarea class="form-control" rows="5" name="coinbase_btn" placeholder="{{ __('Coinbase Commerce Button Code') }}">{{ $user[0]->coinbase_btn }}</textarea>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" value="{{$user[0]->client_id}}" name="client_id">
                    @else
                    	<div class="row form-group">
                            <div class="col"><label class="col-form-label">Options for payment will be made available upon approval of your first pitch.</label></div>
                        </div>
                        <input type="hidden" class="form-control" value="{{$user[0]->client_id}}" name="client_id">
                        <input type="hidden" class="form-control" value="{{$user[0]->paypal_btn}}" name="paypal_btn">
                        <input type="hidden" class="form-control" value="{{$user[0]->coinbase_btn}}" name="coinbase_btn">
                    @endif
                @endrole
                <div class="form-group row mb-0">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			var maxLength	= 240;
			var leng		= $('#user_bio').val().length;
			$('#charNum').text(maxLength - leng);
		});
    </script>
@endpush