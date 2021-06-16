@extends('layouts.app')

@section('title', 'CHECKOUT FUNDS '.Config::get('app.app_title'))
@section('meta_keywords', '')
@section('meta_description', '')

@php
$amount			= $fundraising[0]->amount;
$order_amount	= str_replace(',', '', $fundraising[0]->amount);
$order_id		= $fundraising[0]->reference_id;
$description	= $fundraising[0]->title;
$customer_name	= $fundraising[0]->funder_name;

@endphp

@section('content')
<!-- Section 1 -->
<div class="row">
    <div class="col-md-12">
        <div class="page_header">
            <h2>Contribute To This Project</h2>
        </div>
        <div class="sect_wrapper">     
            <div class="row">
            	<div class="col-md-12">
                	You can contribute to <strong>"{{ $fundraising[0]->title }}"</strong> by sending a donation via any of the following methods. <br />
                    Funds are sent directly to the writers themselves to fund their work.
                </div>
            </div>
            
            <div class="row">
            	<div class="col-md-12">
                    @if(Session::has('message'))
                        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-sm-5 text-sm-center justify-content-center pt-4 pb-4"> <small class="text-sm">Order number</small>
                            <h3 class="mb-3">{{ $order_id }}</h3> <small class="text-sm">Contribute Amount</small>
                            <div class="row px-3 justify-content-sm-center">
                                <h1 class=""><span class="text-md font-weight-bolder mr-0">$</span><span class=" text-md font-weight-bolder">{{ $amount }}</span></h1>
                            </div>
                        </div>
                        <div class="col-sm-7 border-line text-sm-center justify-content-center pt-4 pb-4">
                            <h3 class="mb-3 text-left text-md font-weight-bolder">Send a Tip to {!! $user_info->name !!}</h3>
                            <div class="form-group">
                                <p class="pull-left">Use your credit card or bank account:</p>
                                <div id="paypal-button-container" style="clear: both; text-align: left;">
                                    {!! $user_info->paypal_btn !!}
                                </div>
                                <br />
                                <div id="bitcoin-button-container" style="float:left;clear: both;">
                                    Tip in crypto via <img style="width:200px;" src="{{ asset('imgs') }}/coinbase-commerce.png"/><br />
                                    
                                    {!! $user_info->coinbase_btn !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
