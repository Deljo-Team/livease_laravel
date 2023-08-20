@extends('layouts.admin')

@section('content')
{{-- <div class="container">
    <table id="myTable">
        <thead>
            <tr>
                <th>Country</th>
                <th>Country Code</th>
                <th>Country Phone Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
            <tr>
                <td>{{$country->name}}</td>
                <td>{{$country->code}}</td>
                <td>{{$country->phone_code}}</td>
                <td>
                    <a href="{{route('countries.edit', $country->id)}}" class="btn btn-primary">Edit</a>
                    <form action="{{route('countries.destroy', $country->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button> 
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div> --}}

<div class="container">
    <div class="card">
        <div class="card-header">Manage Countries</div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush