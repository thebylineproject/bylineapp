@extends('layouts.app')

@section('title', 'MANAGE PITCHES'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->

<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Manage Pitches <span class="search_count">{{count($pitches)}} Records</span></h2>
        </div>
        <div class="sect_wrapper">
            @if(Session::has('message'))
            	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif
            <div id="reslt"></div>
            <h4 class="updates_heading">All Pitches <span class="submission_filters_fields text-right">
                <a href="{{ route('create_pitch') }}"><button class="act_btn">Create New Pitch</button></a></span></h4>
                <table class="table submiss_table all_submiss display" id="manage_submissions" style="width:100%; font-size: 14px;">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$pitches->isEmpty())
                        @foreach($pitches as $pitch)
                            <tr>
                                <td><b><a href="{{ url('/details/'.$pitch->pid) }}">{{ $pitch->title }}</a></b></td>
                                <td>{{ $pitch->user_name }}</td>
                                <!--<td><a href="{{ url('/download/'.$pitch->budget_sheet) }}">Download</a></td>-->
                                <td>@php if($pitch->status == 2){ echo 'Declined'; } else if($pitch->status == 1){ echo 'Approved'; }else{ echo 'Pending'; }@endphp</td>
                                <td>{{date('Y-m-d', strtotime($pitch->created_at))}}</td>
                                <td>
                                @role('admin')
                                	@php if($pitch->status == 2){ echo 'Declined'; } else if($pitch->status == 1){ echo 'Approved'; }else{@endphp
                                        <button type="button" class="btn btn-success" onclick="approvePitch({{ $pitch->pid }} , 'Accepted');">Accepted</button>
                                        <button type="button" class="btn btn-danger" onclick="approvePitch({{ $pitch->pid }} , 'Declined');">Declined</button>
                                    @php } @endphp
                                @endrole
                                @role('editor')
                                	@php if($pitch->status == 2){ echo 'Declined'; } else if($pitch->status == 1){ echo 'Approved'; }else{@endphp
                                        <button type="button" class="btn btn-success" onclick="approvePitch({{ $pitch->pid }} , 'Accepted');">Accepted</button>
                                        <button type="button" class="btn btn-danger" onclick="approvePitch({{ $pitch->pid }} , 'Declined');">Declined</button>
                                    @php } @endphp
                                @endrole
                                @role('writer')
                                 --
                                @endrole
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
@endsection

@push('scripts')
	<script type="text/javascript">
        $(document).ready(function() {
            $('#manage_submissions').DataTable({
                responsive: true,
                /*"columnDefs": [
                    {
                        "targets": [ 5 ],
                        "visible": false,
                        "searchable": false
                    }
                ],
                "order": [[ 5, 'desc' ]]*/
            });
        });
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
