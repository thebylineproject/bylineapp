@extends('layouts.app')

@section('title', 'TIPPING REPORT'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@php
	$current_date = date('Y-m-d');
@endphp

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Tipping Report <span class="search_count">{{ count($fundraising) }} Records</span></h2>
        </div>
        <div class="sect_wrapper">   
            <form style="margin-bottom: 20px;" enctype="multipart/form-data" method="POST" action="{{ route('filter_report') }}">
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
                <div class="row form-group">
                    <div class="col tipping_report_filter">
                    	<input style="float: left; margin-right: 10px;width: 25%;" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" value="" class="form-control datepicker" placeholder="Start date" name="start_date"  >
                    	<input style="float: left;margin-right: 10px; width: 25%;" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}" value="" class="form-control datepicker" placeholder="End date" name="end_date">
                        <select style="float: left; margin-right: 10px; width: 25%;" class="form-control" name="amount">
                            <option value="">Select Amount</option>
                            <option value="20"> > $20</option>
                            <option value="50"> > $50</option>
                            <option value="100"> > $100</option>                                                       
                        </select>
                        <button type="submit" class="btn btn-info">Filter</button>
                    </div>
                </div>
            </form>
		<div>
        <table class="table submiss_table all_submiss display" id="reports" style="width:100%; font-size: 14px;">
            <thead>
                <tr>
                    <th>Donor Name</th>
                    <th>Submission Name</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Date</th>                    
                </tr>
            </thead>
            <tbody>@php $sum_tot_Price = 0; @endphp
                @if(!empty($fundraising))
                	@foreach($fundraising as $funding)
                        <tr>
                            <td>{{ $funding->funder_name }}</td>
                            <td>{{ $funding->sub_title }}</td>
                            <td>{{ $funding->payment_method }}</td>
                            <td>${{ $funding->amount }}</td>
                            <td>{{date('d/m/Y', strtotime($funding->created_at))}}</td>
                        </tr>
                        @php $sum_tot_Price += $funding->amount_paid; @endphp
                    @endforeach
                    <tr><td colspan="3"></td><td>@php echo '<b> Total: $'.number_format($sum_tot_Price, 2).'<b>'; @endphp</td><td></td></tr>
                @else
                    <tr>
                        <td colspan="3"><b>No record found</b></td>                       
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('#reports').DataTable({
			responsive: true,
			"order": [[ 2, "desc" ]]
		});
	});
</script>
@endpush