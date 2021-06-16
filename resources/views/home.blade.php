@extends('layouts.app')

@section('content')
<div class="container">
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

                @role('developer')
                    You are logged in developer!
                @endrole
                
                @role('manager')
                    You are logged in manager!
                @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
