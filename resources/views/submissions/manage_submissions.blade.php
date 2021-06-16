@extends('layouts.app')

@section('title', 'MANAGE ACCEPTED PITCHES'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
@role('writer')
    @if($user_info->welcome_note == 0)
        <div class="alert alert-success alert-dismissible" role="alert" style="margin-top:20px;">
            <h4 class="alert-heading"><u>Welcome to The Byline Project!</u></h4>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>As a registered user, you will have the ability to create story submissions, streamline communications with your editor around your pitches, and if accepted, your entire editing process will happen right here. The moment a story goes live, your online community can financially support your content they find valuable through direct-to-reporter tipping. <br />
            Get started by filling out the below information. Please note, bios will be public-facing with your final published piece if accepted.</p>
            <hr>
            <p class="mb-0"><a href="{{ route('my_profile') }}" class="alert-link alert-link-hvr">Editing your writer profile</a></p>
            <p class="mb-0"><a href="{{ route('my_profile') }}" class="alert-link alert-link-hvr">Entering your payment information</a></p>
        </div>
    @endif
@endrole
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Manage Accepted Pitches <span class="search_count">{{count($submissions)}} Records</span></h2>
        </div>
        
        <div class="sect_wrapper">
            @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            
            @if(Request::get('message') == 'success')
            	<p class="alert alert-success">Submission published successfully.</p>
            @endif
            @if(Request::get('message') == 'error')
            	<p class="alert alert-danger">Token Authentication Error!, Submission not published.</p>
            @endif
            
            <div id="reslt"></div>
            <h4 class="updates_heading">All Accepted Pitches <span class="submission_filters_fields text-right" style="width: 80%;">
                    @role('admin')
                    <div>
                        <div id="authorize_button" onclick="handleAuthClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Login with Google</div>
                        <div id="signout_button" onclick="handleSignoutClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Sign Out Google</div>
                    </div>
                    @endrole
                    @role('editor')
                    <div>
                        <div id="authorize_button" onclick="handleAuthClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Login with Google</div>
                        <div id="signout_button" onclick="handleSignoutClick();" class="text-left" style="display: none; cursor:pointer;"><img width="20px" style="margin-bottom:3px; margin-right:5px;" alt="Google sign-in" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" /> Sign Out Google</div>
                    </div>
                    @endrole
                    
                    <a href="{{ url('/pitches/create') }}"><button class="act_btn">Create New Pitch</button></a>
                    <a href="{{ url('/pitches') }}"><button class="act_btn">Manage Pitches</button></a>
                    <!--<a href="{{ url('/submission/create') }}"><button class="act_btn">Create New Submission</button></a>-->
                </span></h4>
            <table class="table submiss_table all_submiss display" id="manage_submissions" style="width:100%; font-size: 14px;">
                <thead>
                    <tr>
                        <th>Date Created</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th width="15%">Status</th>
                        @role('admin')
                        <th>Tipping Goal</th>
                        @endrole
                        @role('editor')
                        <th>Tipping Goal</th>
                        @endrole
                        <!--<th>Updated</th>-->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$submissions->isEmpty())
                    @foreach($submissions as $submission)
                    @php
                    $textt = '';
                    $text = preg_replace('~[^\pL\d]+~u', '-', $submission->title);

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
                    <tr>
                        <td>{{date('Y-m-d', strtotime($submission->created_at))}}</td>
                        <td><b><a href="{{ url('/edit_submissions/'.$submission->sid) }}">{{ $submission->title }}</a></b></td>
                        <td><strong>{{ $submission->user_name }}</strong></td>
                        <td><span class="sub_{{ $submission->status }}">{{ $submission->status }}</span></td>
                        @role('admin')
                            @if($submission->fundraising_goal != '')
                            	<td>${{ $submission->fundraising_goal }}</td> 
                            @else
                            	<td></td>
                            @endif
                        @endrole 
                        @role('editor')
                            @if($submission->fundraising_goal != '')
                            	<td>${{ $submission->fundraising_goal }}</td> 
                            @else
                            	<td></td>
                            @endif
                        @endrole 
                        <!--<td>{{date('Y-m-d', strtotime($submission->updated_at))}}</td>-->
                        <td>
                            <div class="btn-group">
                                <button type="button" id="actns" class="act_btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                <div class="dropdown-menu" id="actn_drop" style="position:absolute !important; width:190px !important;">
                                    <a class="dropdown-item" href="{{ url('/edit_submissions/'.$submission->sid) }}">Edit Submission</a>
                                    @role('admin')
                                    <a class="dropdown-item" href="{{ url('/milestones/'.$submission->sid) }}">Milestones</a>
                                    <a style="display:none;" class="dropdown-item" href="{{ url('/publish_submissions/'.$submission->sid) }}">Publish Submission</a>
                                    @if($submission->status == 'Draft')
                                    <a class="dropdown-item" href="https://docs.google.com/document/d/{{ $submission->doc_id }}" title="View Google Document" target="_blank">View G-Doc</a>
                                    @else
                                    <a class="dropdown-item createdoc" href="javascript:;" title="Draft and create docuemnt" onclick="create_google_doc('{{ $submission->title }}', '{{ $submission->sid }}');" style="display:none;">Create G-Doc</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url('/fundraising/'.$submission->sid) }}">Track Tipping</a>
                                    <!--<a style="display:block;" class="dropdown-item" href="{{ url('/share/'.Crypt::encryptString($submission->sid)) }}">Share Submission</a>-->                                                
                                    @if($submission->status == 'Fundraising')
                                    <a style="display:block;" class="dropdown-item" href="{{ url('/share/'.$submission->sid.'/'.$textt) }}">View Tipping Page</a>
                                    @endif
                                    @endrole
                                    @role('editor')
                                    <a class="dropdown-item" href="{{ url('/milestones/'.$submission->sid) }}">Milestones</a>
                                    <a style="display:none;" class="dropdown-item" href="{{ url('/publish_submissions/'.$submission->sid) }}">Publish Submission</a>
                                    @if($submission->status == 'Draft')
                                    <a class="dropdown-item" href="https://docs.google.com/document/d/{{ $submission->doc_id }}" title="View Google Document" target="_blank">View G-Doc</a>
                                    @else
                                    <a class="dropdown-item createdoc" href="javascript:;" title="Draft and create docuemnt" onclick="create_google_doc('{{ $submission->title }}', '{{ $submission->sid }}');" style="display:none;">Create G-Doc</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ url('/fundraising/'.$submission->sid) }}">Track Tipping</a>

                                    @if($submission->status == 'Fundraising')
                                    <a style="display:block;" class="dropdown-item" href="{{ url('/share/'.$submission->sid.'/'.$textt) }}">View Tipping Page</a>
                                    @endif
                                    @endrole
                                    @role('writer')
                                    <!--<a class="dropdown-item" href="{{ url('/fundraising/request/'.$submission->sid) }}">Tips Requests</a>-->
                                    <a class="dropdown-item" href="{{ url('/milestones/'.$submission->sid) }}">Milestones</a>

                                    @if($submission->status == 'Fundraising')
                                    <a style="display:block;" class="dropdown-item" href="{{ url('/share/'.$submission->sid.'/'.$textt) }}">View Tipping Page</a>
                                    @endif
                                    @if($submission->status == 'Draft')
                                    <a class="dropdown-item" href="https://docs.google.com/document/d/{{ $submission->doc_id }}" title="View Google Document" target="_blank">View G-Doc</a>
                                    @endif
                                    @endrole
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5"><b>No record found</b></td>                       
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    #actn_drop{
        position:absolute !important;
        top:32px !important;
    }
    #actn_drop.dropdown-menu::before {
        left:10px !important;
        right:auto !important;
    }
    .alert-link-hvr:hover{
        text-decoration:underline !important;
    }
</style>
@endsection

@push('scripts')
	<script>
    	var CLIENT_ID	= "{{ env('CLIENT_ID') }}";
    	var API_KEY		= "{{ env('API_KEY') }}";
    </script>
	<script src="{{ asset('js/google.js')}}"></script>
	<script async defer onload="this.onload = function(){}; handleClientLoad()" onreadystatechange="if (this.readyState === 'complete') this.onload()" src="https://apis.google.com/js/api.js"></script>
	
	<script type="text/javascript">
        $(document).ready(function() {
            $('#manage_submissions').DataTable({
                responsive: true,
                    /*"columnDefs": [
                    {
                    "targets": [ 4 ],
                            "visible": false,
                            "searchable": false
                    }
                    ],*/
                    "order": [[ 0, 'desc' ]]
            });
        });
    </script>
@endpush