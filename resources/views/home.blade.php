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
                    <p>{{$servicemenCount}}</p>
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection
