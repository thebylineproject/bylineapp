@extends('layouts.app')

@section('title', 'CREATE NEW PITCH'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')

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

<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Create a Pitch</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Create Pitch
                <span style="width: 50%;" class="submission_filters_fields text-right"><span style="width: 100% !important;" class="mobileChng submission_filters_fields text-right">
                    <a href="{{ route('pitches') }}"><button class="act_btn back_btn"><img src="{{ asset('imgs/back_btn.svg') }}"></button></a>
                </span>
            </h4>
            <form enctype="multipart/form-data" method="POST" action="{{ route('store_pitch') }}">
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                
                <div class="form-group">
                	<label class="col-form-label">{{ __('Pitch Title') }}:<span>*</span></label>
                    <input type="text" name="title" class="form-control col-lg-6" value="{{ old('title') }}" placeholder="Pitch Title" id="title" required="required">
                    @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Pitch Story') }}:<span>*</span></label>
                    <textarea name="description" id="pitch_story" onkeyup="countChar(this, '400')" rows="5" class="form-control create_submissions col-lg-8" placeholder="Submit your story" >{{ old('description') }}</textarea>
                    <div id="char_count"><span id="charNum"></span> Character(s) Remaining</div>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('What sources will you speak to? (please note only submissions with 5 or more sources will qualify for acceptance) ') }}<span>*</span></label>
                    <textarea name="what" rows="5" class="form-control create_submissions col-lg-8" placeholder="What sources will you speak to?" >{{ old('what') }}</textarea>
                    @error('what')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Why does this story work for our audience?') }}<span>*</span></label>
                    <textarea name="why" id="pitch_audience" onkeyup="countChar2(this, '200')" rows="5" class="form-control create_submissions col-lg-8" placeholder="Why does this story work for our audience?">{{ old('why') }}</textarea>
                    <div id="char_count2"><span id="charNum2"></span> Character(s) Remaining</div>
                    @error('why')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('How long will you need to report this story?') }}<span>*</span></label>
                    <textarea name="how" rows="5" class="form-control create_submissions col-lg-8" placeholder="How long will you need to report this story?">{{ old('how') }}</textarea>
                    @error('how')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                
                <div class="form-group">
                	<label class="col-form-label">{{ __('Please link to any relevant works on the subject') }}:<span>*</span></label>
                    <input type="text" name="rel_link_1" class="form-control form-group col-lg-6" value="{{ old('rel_link_1') }}" placeholder="Relevant Link 01">
                        @error('rel_link_1')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    <input type="text" name="rel_link_2" class="form-control form-group col-lg-6" value="{{ old('rel_link_2') }}" placeholder="Relevant Link 02">
                        @error('rel_link_2')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    <input type="text" name="rel_link_3" class="form-control form-group col-lg-6" value="{{ old('rel_link_3') }}" placeholder="Relevant Link 03">
                        @error('rel_link_3')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                </div>
                <div class="form-group">
                	<label class="col-form-label">{{ __('Images') }}:</label>
                    <input style="border: none;padding-left: 0px;" type="file" class="form-control" name="images[]" multiple>
                    @error('images')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary createPitches">Submit</button>
            </form> 
        </div>
    </div>
</div>
<style>.invalid-feedback{display:inline-block;}</style>
@endsection

@push('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			var maxLength	= 400;
			var leng		= $('#pitch_story').val().length;
			$('#charNum').text(maxLength - leng);
			
			//Second
			var maxLength2	= 200;
			var leng2		= $('#pitch_audience').val().length;
			$('#charNum2').text(maxLength2 - leng2);
		});
    </script>
@endpush