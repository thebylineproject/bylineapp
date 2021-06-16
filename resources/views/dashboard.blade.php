@extends('layouts.app')

@section('title', 'DASHBOARD | IRP SYSTEM')
@section('meta_keywords', '')
@section('meta_description', '')

@section('content')
        <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Dashboard home</div>
        
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
        
                        @role('admin')
                            You are logged in admin!
                        @endrole
                        
                        @role('editor')
                            You are logged in editor!
                        @endrole
                        
                        @role('writer')
                            You are logged in writer!
                        @endrole
                        </div>
                    </div>
                </div>
            </div>
@endsection
