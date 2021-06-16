@extends('layouts.app')

@section('title', 'CHECKOUT FUNDS '.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Checkout Funds</h2>
        </div>
        <div class="sect_wrapper">
            <h4 class="updates_heading">Checkout Funds</h4>
            <form>
                @if(Session::has('message'))
                	<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                @endif
                @csrf
            	<div class="row">
                    <div class="col-sm-5 text-sm-center justify-content-center pt-4 pb-4"> <small class="text-sm text-muted">Order number</small>
                        <h5 class="mb-5">{{$fundraising[0]->reference_id}}</h5> <small class="text-sm text-muted">Payment amount</small>
                        <div class="row px-3 justify-content-sm-center">
                            <h2 class=""><span class="text-md font-weight-bold mr-2">$</span><span class="text-danger">{{$fundraising[0]->amount}}</span></h2>
                        </div>
                    </div>
                    <div class="col-sm-7 border-line pb-3">
                        <div class="form-group">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
