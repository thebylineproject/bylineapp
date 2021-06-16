@extends('layouts.app')

@section('title', 'UPDATE SUBMISSION'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@php
    $text = preg_replace('~[^\pL\d]+~u', '-', $submissions[0]->title);
    
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    
    // trim
    $text = trim($text, '-');
    
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    
    // lowercase
    $textt = strtolower($text);
@endphp

@section('content')

<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Edit Submission</h2>
        </div>
        <div class="sect_wrapper">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="updates_heading">Update Submission:</h4>
                        </div>
                        <div class="col-md-4">                    
                            <span style="width: 100% !important" class="submission_filters_fields text-right">
                                <a href="{{ url('/milestones/'.$submissions[0]->sid) }}"><button class="act_btn back_btn "><img title="Manage Milestones" src="{{asset('imgs')}}/magage-Button.svg"></button></a>&nbsp;&nbsp;
                                <a onclick="return confirm('Are you sure you want to detele?')" href="{{ url('/delete_submissions/'.$submissions[0]->sid) }}"><button class="act_btn back_btn"><img title="DELETE" src="{{asset('imgs')}}/del_icon.svg"></button></a>&nbsp;&nbsp;
                                <a href="{{ url('/submissions') }}"><button class="act_btn back_btn"><img title="Back to Submissions" src="{{asset('imgs')}}/back_btn.svg"></button></a>
                            </span>
                        </div>
                        <div class="col-md-12">
                            <form id="edit_submisssion" method="POST" enctype="multipart/form-data"  action="{{ route('update_submission') }}">
                                <input type="hidden" class="form-control" value="{{$submissions[0]->sid}}" id="sid" name="sid">
                                <input type="hidden" class="form-control" value="{{$submissions[0]->tip_enable}}" id="tip_enable" name="tip_enable">
                                <input type="hidden" class="form-control" value="{{$submissions[0]->doc_id}}" id="doc_id">
                                @csrf
                                @if(Session::has('message'))
                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                @endif
                                
                                <div class="form-group">
                                    <label for="name" class="col-md-4 col-form-label">{{ __('Title') }}<span>*</span>:</label>
                                    <input type="text" name="title" value="{{$submissions[0]->title}}" class="form-control" placeholder="Title" id="title" required="required">
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-md-12 google_doc_submissions">
                                        <div>
                                            <div id="authorize_button" onclick="handleAuthClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Login with Google</div>
                                            <div id="signout_button" onclick="handleSignoutClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Sign Out Google</div>
                                        </div>
                                        @if($submissions[0]->doc_id != '')
                                            <iframe src="https://docs.google.com/document/d/{{$submissions[0]->doc_id}}" width="100%" height="500" style="border:1px solid black;"></iframe>
                                        @endif
                                    </div>
                                </div>      
    
                                @role('admin')
                                    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
                                    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Enable Tipping') }}:</label>
                                        <input id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="outline-dark" data-style="android"  data-width="100" data-style="slow">
                                        <div id="console-event"></div>
                                    </div>
                                    <style>
                                        .toggle.android { border-radius: 0px;}
                                        .toggle.android .toggle-handle { border-radius: 0px; }
                                    </style>
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Tip Goal') }}:</label>
                                        <input type="text" name="fundraising_goal" value="{{$submissions[0]->fundraising_goal}}" class="form-control col-md-4" placeholder="Tip Goal"  id="fundraising_goal">
                                    </div>
                                @endrole
                
                                @role('editor')
                                    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
                                    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Enable Tipping') }}:</label>
                                        <input id="toggle-event" type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="outline-dark" data-style="android"  data-width="100" data-style="slow">
                                        <div id="console-event"></div>
                                    </div>
                                    <style>
                                        .toggle.android { border-radius: 0px;}
                                        .toggle.android .toggle-handle { border-radius: 0px; }
                                    </style>
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Tip Goal') }}:</label>
                                        <input type="text" name="fundraising_goal" value="{{$submissions[0]->fundraising_goal}}" class="form-control col-md-4" placeholder="Tip Goal"  id="fundraising_goal">
                                    </div>
                                @endrole
                                
                                @role('admin')
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Status') }}<span>*</span>:</label>
                                        <select class="form-control col-md-4" id="submission_status" name="submission_status">
                                            @foreach($submission_status as $each_submission_status)                        
                                                @if($each_submission_status->title == $submissions[0]->status)                        
                                                    <option selected="selected" value="{{$each_submission_status->title}}">{{$each_submission_status->title}}</option>
                                                @else
                                                <option value="{{$each_submission_status->title}}">{{$each_submission_status->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole
                                
                                @role('editor')
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Status') }}<span>*</span>:</label>
                                        <select class="form-control col-md-4" id="submission_status" name="submission_status" required>
                                            @foreach($submission_status as $each_submission_status)                        
                                                @if($each_submission_status->title == $submissions[0]->status)                        
                                                    <option selected="selected" value="{{$each_submission_status->title}}">{{$each_submission_status->title}}</option>
                                                @else
                                                    <option value="{{$each_submission_status->title}}">{{$each_submission_status->title}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                @endrole
                
                                @role('writer')
                                    <div class="form-group">
                                        <label for="name" class="col-md-4 col-form-label">{{ __('Status: ') }}</label>
                                        <input type="text" value="{{$submissions[0]->status}}" class="form-control" disabled="disabled">
                                    </div>
                                    <input type="hidden" name="submission_status" value="{{$submissions[0]->status}}" />
                                    <input type="hidden" name="fundraising_goal" value="{{$submissions[0]->fundraising_goal}}" />
                                @endrole
                                
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Images') }}:</label>
                                    <input type="file" style="border: none;padding-left: 0px;" class="form-control" name="images[]" placeholder="address" multiple>
                                </div>
                        </div>
                	</div>
				</div>
    			<div class="col-md-4">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="chartContainer3" style="text-align:center;">
                                <h3>Author Info</h3>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($user[0]->profile_pic)
                                            <img width="150" height="" title="{{$user[0]->name}}" src="{{asset('assets/images/user_profile/')}}/{{$user[0]->profile_pic}}">
                                        @else
                                            <img src="{{ asset('assets/images/user_profile/noimage.png') }}" width="150"/>
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
                                        <i class="fa fa-phone"></i> {{$user[0]->phone}},<br />
                                        @endif
                                        
                                        @if($user[0]->email)
                                        <i class="fa fa-envelope"></i> <a href="mailto:{{$user[0]->email}}">{{$user[0]->email}}</a><br /><br />
                                        @endif
                                    </div>
                                </div>
                            </div>
                		</div>
                        @if($submissions[0]->tip_enable == 0)
                            @if($fundraisingAmount > 0)
                                <div class="col-md-12">
                                    <div id="chartfundContainer" style="height: 300px;"></div>
                                </div>
                            @endif
                        @endif
                        @if($submissions[0]->status == 'Fundraising')
                            <div class="col-md-12 edit_sub_author_btn" style="text-align:center; margin-top: 10px;">
                                <button type="button" class="act_btn"><a href="{{ url('/share/'.$submissions[0]->sid.'/'.$textt) }}">VIEW TIPPING PAGE</a></button>
                            </div>
                        @endif
                        @role('admin')
                            <div class="col-md-12 edit_sub_author_btn" style="text-align:center; margin-top:10px;">
                                <button type="button" onclick="verify_userAuth_and_publish_submission({{$submissions[0]->sid}})" class="act_btn">PUBLISH TO WEBSITE</button>
                            </div>
                        @endrole
                        @role('editor')
                            <div class="col-md-12 edit_sub_author_btn" style="text-align:center; margin-top:10px;">
                                <button type="button" onclick="verify_userAuth_and_publish_submission({{$submissions[0]->sid}})" class="act_btn">PUBLISH TO WEBSITE</button>
                            </div>
                        @endrole
                        <div id="content"></div>
            		</div>
            	</div>
            </div>
            <div class="row library_imgs" style="margin-top: 30px;">
				<div class="col-md-8">
					<div class="row">
						<div class="col-md-12">
							@if($submissions[0]->images)
								<div class="form-group">
									<h3>Library</h3>
								</div>
								@foreach(explode('|', $submissions[0]->images) as $key => $path)
									@if($path)
									<div style="padding: 5px; height: 150px; width: 190px;text-align: center; display: inline-block;margin: 10px;border: 2px solid #e3e3e3;" class="form-group" id="{{$key}}">
										<span style="width: 100%;display: inline-block;"> <img style="max-width: 100%; margin-top: 10px;" height="100" src="{{asset("assets/images/$path")}}"></span> <a  onclick="removeImage('{{$key}}',{{$submissions[0]->sid}},'{{$path}}')" style="cursor: pointer;"> <span style="">Delete</span> </a>
									</div>
									@endif
								@endforeach
							@endif
						</div>
						<div class="col-md-12">
							<div class="form-group">
                                <label for="name" class="col-md-4 col-form-label">{{ __('Pitch Summary') }}<span>*</span>:</label>
                                <textarea name="description" class="form-control create_submission" placeholder="Pitch Summary" required="required">{{$submissions[0]->description}}</textarea>
							</div>
						</div>
						<div class="col-md-12">
                            <br>
                            <button type="submit" class="btn btn-primary">Submit</button>
							</form>
						</div>
					</div>
				</div>
			</div>
            <div class="row">
            	<div class="col-md-4"></div>
            </div>
		</div>
    </div>
    <p id="loading-indicator" style="display:none;">Processing...</p>
</div>
<style>    
    #loading-indicator {
		background-color: rgba(0, 0, 0, .5);
		bottom: 0;
		box-sizing: border-box;
		font-size: 1px;
		height: 100%;
		left: 0;
		margin: 0 !important;
		padding: 0 !important;
		position: fixed;
		right: 0;
		top: 0;
		width: 100%;
		z-index: 2147483646;
	}
	#loading-indicator::before {
		background: url(/imgs/Spinner-2.gif) center center no-repeat rgba(0, 0, 0, 0);
		content: "";
		height: 70px;
		margin-left: -35px;
		margin-top: -70px;
		width: 70px;
		z-index: 2;
	}
	#loading-indicator::after, #loading-indicator::before {
		box-sizing: border-box;
		left: 50%;
		position: absolute;
		top: 50%;
	}
	#loading-indicator {
		font-size: 1px;
	}
	#loading-indicator::after {
		background: #fff;
		border-radius: 5px;
		color: #000;
		content: "Publish Submission Processing... ";
		font-family: arial;
		font-size: 17px;
		height: 110px;
		line-height: 98px;
		margin-left: -150px;
		margin-top: -75px;
		padding-top: 35px;
		text-align: center;
		width: 300px;
		z-index: 1;
	}
	#loading-indicator::after, #loading-indicator::before {
		box-sizing: border-box;
		left: 50%;
		position: absolute;
		top: 50%;
	}
	.edit_sub_author_btn .act_btn a {
		color: #000;
	}
</style>
@endsection

@push('scripts')
    <!--https://gitbrent.github.io/bootstrap4-toggle/-->
	<script>
    	var CLIENT_ID	= "{{ env('CLIENT_ID') }}";
    	var API_KEY		= "{{ env('API_KEY') }}";
    </script>
	<script src="{{ asset('js/canvasjs.min.js')}}"></script>
	<script src="{{ asset('js/google.js')}}"></script>
	<script async defer onload="this.onload = function(){}; handleClientLoad()" onreadystatechange="if (this.readyState === 'complete') this.onload()" src="https://apis.google.com/js/api.js"></script>
    
    <script>
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartfundContainer", {
				animationEnabled: true,
					title: {
					text: "Tipping"
				},
				axisY:{
					prefix: "$",
					maximum: '{{$fundraising_goal}}',
				},
				axisY2: {
					title: "Millions of Barrels/day",
					titleFontColor: "#C0504E",
					lineColor: "#C0504E",
					labelFontColor: "#C0504E",
					tickColor: "#C0504E"
				},
				toolTip:{
					enabled: true, //disable here
					animationEnabled: true //disable here
				},
				legend: {
					cursor: "pointer",
					itemclick: toggleDataSeries
				},
				data: [{
					type: "column",
					dataPoints: [{label: "Total", y: {{$fundraisingAmount}}}]
				}]
			});
			chart.render();
			function toggleDataSeries(e) {
				if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
					e.dataSeries.visible = false;
				} else {
					e.dataSeries.visible = true;
				}
				chart.render();
			}
		}
		//$('#toggle-event').bootstrapToggle('on');
		$(function() {
			if ($('#tip_enable').val()==1){
				$('#toggle-event').bootstrapToggle('off'); 
			}
			if ($('#tip_enable').val()==0){
				$('#toggle-event').bootstrapToggle('on'); 
			}
			$('#toggle-event').change(function() {
				var status = $(this).prop('checked');
				if(status == true){
                	$('#tip_enable').val(0);
				}else{
                	$('#tip_enable').val(1);
				}
			});                                                                                                     
		});
		
		function verify_userAuth_and_publish_submission(sub_id){
			$('#loading-indicator').show();
			var islogin = gapi.auth2.getAuthInstance().isSignedIn.get();
			var doc_id	= $('#doc_id').val();
			
			if(islogin){
				if(doc_id != ''){
					get_google_doc_content(doc_id, sub_id);
				}else{
					$('#loading-indicator').hide();
					alert('Google doc have not created yet');
				}
			}else{
				$('#loading-indicator').hide();
				alert('You are not login with your Google account.');
			}
		}
	</script>
@endpush
