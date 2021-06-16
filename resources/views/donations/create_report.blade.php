@extends('layouts.app')

@section('title', 'Reports'.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Report</h2>
        </div>
        <div class="sect_wrapper">   
            <form style="margin-bottom: 20px;" enctype="multipart/form-data" method="POST" action="{{ route('store_submission') }}">
                @if(Session::has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
<div class="row form-group">
                        	<div class="col">
                            	<input style="float: left; margin-right: 10px;width: 25%;" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}"  value="" class="form-control datepicker" id="start_date" placeholder="Start date" name="start_date"  >
                                <input style="float: left;margin-right: 10px; width: 25%;" type="text" pattern="\d{4}-\d{1,2}-\d{1,2}"  class="datepicker form-control " id="end_date" placeholder="End date" name="end_date"  >

                            	<select style="float: left; margin-right: 10px; width: 25%;" class="form-control" name="role" id="role">
                                     <option value=""> Select Amount</option>
                                                                         <option value="20"> > $20</option>
                                                                         <option value="50"> > $50</option>
                                                                         <option value="100"> > $100</option>
                                                       
								</select>
                          <button type="submit" class="btn btn-primary">Submit</button>  </div>                            
                        
                
                </div>
            </form>
            
            
            <div>
                
                 <table class="table submiss_table all_submiss display" id="manage_users" style="width:100%">
                <thead>
                    <tr>
                        <th>Donor name</th>
                        <th>Amount</th>
                        <th>Date</th>                    
                    </tr>
                </thead>
                <tbody>
                    
                    <tr>
                        <td><b></b></td>
                         <td><b></b></td>
                          <td><b></b></td>
                     
                    </tr>
                   
                </tbody>
            </table>
                
                
            </div>
            
            
            
        </div>
    </div>
</div>

@endsection
