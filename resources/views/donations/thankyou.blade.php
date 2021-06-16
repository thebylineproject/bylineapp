@extends('layouts.app')

@section('title', 'THANK YOU '.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Thank You Page</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Thank you for the tip</h4>
            @guest
            	
            @else
            	<a href="{{ url('/submissions') }}">All Submissions</a>
            @endguest

            
        </div>
    </div>
</div>

@endsection
