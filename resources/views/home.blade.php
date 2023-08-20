@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-around">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header ">{{ __('Customers') }}</div>
                <div class="card-body">
                    <p>{{$customerCount}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header ">{{ __('Vendors') }}</div>
                <div class="card-body">
                    <p>{{$vendorCount}}</p>

                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header ">{{ __('Servicemen') }}</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
