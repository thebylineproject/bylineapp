@extends('layouts.app')

@section('title', 'PITCH DETAILS'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>PITCH DETAILS</h2>
        </div>
        <div class="sect_wrapper">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="updates_heading">PITCH DETAILS: 
                        <span style="width: 100% !important" class="submission_filters_fields text-right">
                            <a href="{{ url('/pitches') }}"><button class="act_btn">Back to Pitches</button></a>
                        </span>
                    </h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="edit_submisssion" method="POST" enctype="multipart/form-data"  action="{{ route('update_submission') }}">
                                <input type="hidden" class="form-control" value="{{$pitch_info[0]->pid}}" id="sid" name="sid">
                                @csrf
                                @if(Session::has('message'))
                                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                                @endif
                				
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('Pitch Title') }}:</label>
                                    <input type="text" name="title" value="{{$pitch_info[0]->title}}" class="form-control" placeholder="Pitch Title" id="title" required="required">
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('Pitch Story') }}:</label>
                                    <textarea name="description" rows="5" class="form-control create_submissions" placeholder="Pitch Story" required="required">{{$pitch_info[0]->description}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('What sources will you speak to? (please note only submissions with 5 or more sources will qualify for acceptance)') }}:</label>
                                    <textarea name="what" rows="5" class="form-control create_submissions" placeholder="What sources will you speak to?" required="required">{{$pitch_info[0]->what}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('Why does this story work for our audience?') }}:</label>
                                    <textarea name="why" rows="5" class="form-control create_submissions" placeholder="Why does this story work for our audience?" required="required">{{$pitch_info[0]->why}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-form-label">{{ __('How long will you need to report this story?') }}:</label>
                                    <textarea name="how" rows="5" class="form-control create_submissions" placeholder="How long will you need to report this story?" required="required">{{$pitch_info[0]->how}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">{{ __('Please link to any relevant works on the subject') }}:<span>*</span></label>
                                    <input type="text" name="rel_link_1" class="form-control form-group col-lg-8" value="{{ $pitch_info[0]->rel_link_1 }}" placeholder="Relevant Link 01" required="required">
                                    <input type="text" name="rel_link_2" class="form-control form-group col-lg-8" value="{{ $pitch_info[0]->rel_link_2 }}" placeholder="Relevant Link 02" required="required">
                                    <input type="text" name="rel_link_3" class="form-control form-group col-lg-8" value="{{ $pitch_info[0]->rel_link_3 }}" placeholder="Relevant Link 03" required="required">
                                </div>
                				
                				<div class="col-md-3">
                                    @if($pitch_info[0]->images)
                                        <div class="form-group">
                                            <h3>Library</h3>
                                        </div>
                                        @foreach(explode('|', $pitch_info[0]->images) as $key => $path)
                                            @if($path)
                                            <div style="padding: 5px; height: 150px; width: 190px;text-align: center; display: inline-block;margin: 10px;border: 2px solid #e3e3e3;" class="form-group" id="{{$key}}">
                                                <span style="width: 100%;display: inline-block;"> <img style="max-width: 100%; margin-top: 10px;" height="100" src="{{asset("assets/images/$path")}}"></span>
                                            </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </form>
                        </div>
                	</div>
				</div>
    			<div class="col-md-4 text-right">
                	@role('admin')
                        @php if($pitch_info[0]->status == 2){ echo '<button type="button" class="btn btn-danger">Pitch has been Declined</button>'; } else if($pitch_info[0]->status == 1){ echo '<button type="button" class="btn btn-success">Pitch has been Approved</button>'; }else{@endphp
                            <button type="button" class="btn btn-success" onclick="approvePitch({{ $pitch_info[0]->pid }} , 'Accepted');">Accepted</button>
                            <button type="button" class="btn btn-danger" onclick="approvePitch({{ $pitch_info[0]->pid }} , 'Declined');">Declined</button>
                        @php } @endphp
                    @endrole
                	@role('editor')
                        @php if($pitch_info[0]->status == 2){ echo '<button type="button" class="btn btn-danger">Pitch has been Declined</button>'; } else if($pitch_info[0]->status == 1){ echo '<button type="button" class="btn btn-success">Pitch has been Approved</button>'; }else{@endphp
                            <button type="button" class="btn btn-success" onclick="approvePitch({{ $pitch_info[0]->pid }} , 'Accepted');">Accepted</button>
                            <button type="button" class="btn btn-danger" onclick="approvePitch({{ $pitch_info[0]->pid }} , 'Declined');">Declined</button>
                        @php } @endphp
                    @endrole
                </div>
            </div>
		</div>
    </div>
</div>
@endsection

@push('scripts')
	<script type="text/javascript">
        function approvePitch(pid, status){
            var token = $("meta[name='csrf-token']").attr("content");
            var data_string = "_token="+token+"&pid="+pid+"&pitchstatus="+status;
            $.ajax({
                url: APP_URL + '/update_pitch',
                type: 'POST',
                data: data_string,
                success: function (response) {
                    location.reload();
                }
            });
        }
    </script>
@endpush