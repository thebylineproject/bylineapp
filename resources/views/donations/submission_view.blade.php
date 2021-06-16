@extends('layouts.app')

@section('title', 'SHARE SUBMISSION'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header text-left">
            <h2>{{$submissions[0]->title}}</h2>
        </div>
        <div class="sect_wrapper">
        	<div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($submissions[0]->images)
                                        @php
                                            $image_paths		= explode('|', $submissions[0]->images);
                                            $image_path_filter	= array_filter($image_paths);                 
                                            $images				= array_values($image_path_filter);
                                        @endphp
                                        @if($images[0])
                                        	<img class="img-fluid" width="575" height="" title="{{$submissions[0]->title}}" src="{{asset('assets/images/')}}/{{$images[0]}}">
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-12" style="margin-top:20px;">
                                	<h2 style="font-size:16px;"><b>Project Description:</b></h2>
                					{!! html_entity_decode($submissions[0]->description) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--<h2 style="font-size:16px;"><b>Introduction:</b></h2>
                                    {{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($submissions[0]->description)), 600, $end='...') }}-->
                                    
                                    <h2 style="margin-top:20px; font-size:16px;">Writer Information:</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                	@if($user[0]->profile_pic != '')
                                                    <img width="150" height="" title="{{$user[0]->name}}" src="{{asset('assets/images/user_profile/')}}/{{$user[0]->profile_pic}}">
                                                    @endif
                                                </div>
                                                <div class="col-md-12">
                                                	@if($user[0]->name)
                                                    {{ucwords($user[0]->name)}} <br />
                                                    @endif
                                                    
                                                    @if($user[0]->city)
                                                    {{$user[0]->city}}, {{$user[0]->state}} <br />
                                                    @endif
                                                    
                                                    @if($user[0]->phone)
                                                    <i class="fa fa-phone"></i> {{$user[0]->phone}}<br />
                                                    @endif
                                                    
                                                    @if($user[0]->email)
                                                    <!--<i class="fa fa-envelope"></i> <a href="mailto:{{$user[0]->email}}">{{$user[0]->email}}</a><br /><br />-->
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                            <div class="col-md-12">
                                                    <p style="line-height:normal; font-size:12px; margin-top: 10px;">{{ \Illuminate\Support\Str::limit(strip_tags(html_entity_decode($user[0]->bio)), 350, $end='...') }}</p>
                                                </div>
                                                
                                            </div>
                                            @if($submissions[0]->tip_enable == 0)
                                            <!--<div class="row" style="margin-top:10px; display:none;">
                                                <div class="col-md-12 mobile50"><button class="act_btn col-md-12" onclick="make_donation_form();">Tip the writer</button></div>
                                            </div>-->
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <!--<div class="row" id="donation" style="display:none; margin-top:10px;">
                                        <div class="col-md-12">
                                            <form enctype="multipart/form-data" method="POST" action="{{ route('donation_checkout') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">{{ __('Name:') }}<span>*</span></label>
                                                            <input type="text" name="funder_name" value="" class="form-control" placeholder="Name" id="funder_name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">{{ __('Amount:') }}<span>*</span></label>
                                                            <input type="text" name="amount" value="" class="form-control" placeholder="Amount" id="amount" required>
                                                            <input type="hidden" name="sid" value="{{$submissions[0]->sid}}">
                                                            <input type="hidden" name="reference_id" value="{{ rand(0, 10000000000) }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btnn btn-primaryy act_btn pull-right">Continue &rarr;</button>
                                            </form>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="col-md-12 share_page_div">
                                Share this page 
 <a onclick="javascript:void window.open('https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}&display=popup', 'Donate Now', 'width=650,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" href="https://www.facebook.com/sharer/sharer.php?u={{Request::url()}}&display=popup"><i class="fa fa-facebook"></i></a>
                                                    <a onclick="javascript:void window.open('https://twitter.com/intent/tweet?text=Donate Now&url={{Request::url()}}', 'Donate Now', 'width=650,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" href="https://twitter.com/intent/tweet?text=Donate Now&url={{Request::url()}}"><i class="fa fa-twitter"></i></a>
                                                    <a onclick="javascript:void window.open('https://www.linkedin.com/shareArticle?mini=true&url={{Request::url()}}&title=Donate Now&summary=Donate Now&source=LinkedIn', 'Donate Now', 'width=650,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" href="https://www.linkedin.com/shareArticle?mini=true&url={{Request::url()}}&title=Donate Now&summary=Donate Now&source=LinkedIn"><i class="fa fa-linkedin"></i></a>
                                                    
                                    <!--<br /><small><strong>{{number_format(count($fundraising))}} backers</strong> pledged ${{number_format($total_donations)}} to help bring this project to life.</small>-->
                                    @if (count($fundraising) > 1)
                                        <!--<br /><small><i class="fa fa-calendar"></i> <strong>Last updated</strong></small> <small style="text-decoration:underline;">{{date('F j, Y', strtotime($latest_donation->paid_at))}}</small>-->
                                    @else
                                    @endif
								</div>
								
                                @if($user[0]->paypal_btn || $user[0]->coinbase_btn)
                                
                                <h4 class="mb-3 text-center text-md font-weight-bolder" style="width:100%;margin-top:30px; margin-bottom:10px;font-size:18px;">Tip {!! $user[0]->name !!} for this story</h4>
                                <div class="row" id="donation" style="flex:100%;text-align: center;">
                                	@if($user[0]->paypal_btn)
                                        <div class="col-md-6 col-xs-12">
                                            <div id="paypal-button-container" style="float:left;clear: both;">
                                                <!--Tip in via -->
                                                <img style="width: 150px; margin: 10px 0;" src="{{ asset('imgs') }}/paypal.png"/><br />
                                                
                                                @php
                                                	$payapal_raw =  explode('=', $user[0]->paypal_btn);
                                                    if($payapal_raw[0] == 'https://www.paypal.com/donate?hosted_button_id'){
                                                    	echo '<a class="btn btn-primary" target="_blank" href="'.$user[0]->paypal_btn.'">Send Tip</a>';
                                                   	}else{
                                                    	echo $user[0]->paypal_btn;
                                                   	}
                                                @endphp
                                                
                                                <!--{!! $user[0]->paypal_btn !!}-->
                                            </div>
                                        </div>
                                    @endif
                                    @if($user[0]->coinbase_btn)
                                        <div class="col-md-6 col-xs-12">
                                            <div id="bitcoin-button-container" style="float:left;clear: both;">
                                                <!--Tip in crypto via --><img style="width:200px;" src="{{ asset('imgs') }}/coinbase-commerce.png"/><br />
                                                {!! $user[0]->coinbase_btn !!}
                                            </div>
                                        </div>
                                    @endif
                                </div>
								@endif
                                <!--<div class="col-md-12"><h2 style="font-size:16px;"><u><b>Funding Goal:</b></u></h2></div>
                                <div class="col-md-12">
                                    @if(!$fundraising->isEmpty())
                                        <strong style="font-size: 1.5em;">${{$submissions[0]->fundraising_goal}}</strong>
                                    @endif
                                </div>
                                <div class="col-md-12" style="margin-top:30px;">
                                	<h2 style="font-size:16px;"><u><b>Donations:</b></u></h2>
                                    <table class="table table-striped table-responsivee">
                                        <thead>
                                            <tr>
                                                <th>Funder Name</th>
                                                <th>Donation Amount</th>
                                                <th>Donation Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	@if(!$fundraising->isEmpty())
                                    			@foreach($fundraising as $key => $value)
                                                    <tr>
                                                        <td>{{$value->funder_name}}</td>
                                                        <td>${{$value->amount}}</td>
                                                        <td>{{date('F j, Y', strtotime($value->paid_at))}}</td>
                                                    </tr>
												@endforeach                    
                                            @else
                                                <tr>
                                                    <td colspan="3">No record found</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>-->
                            </div>
                        </div>
                	</div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1240px !important;
}
.mobile50{
	width:50%;
}
img{
	max-width:100%;
}
.donate-with-crypto span{
	cursor:pointer !important;
}
@media(max-width:414px){
	#paypal-button-container, #bitcoin-button-container {
		width:100%;
		text-align:center;
	}
	#bitcoin-button-container .donate-with-crypto{
		float: none !important;
	}
}
</style>
@endsection

@push('scripts')
	<script type="text/javascript">
        function make_donation_form(){
            $('#donation').toggle();
        }
    </script>
@endpush