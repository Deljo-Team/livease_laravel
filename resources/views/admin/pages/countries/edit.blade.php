@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Edit Country</h5>
          <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>
        <div class="card-body">
          <form id="update">
            @csrf
            <div class="form-group">
              <label for="name"> Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name" value="{{$country->name}}">
            </div>
            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" name="code" class="form-control" id="code" placeholder="Code" value="{{$country->code}}">
            </div>
            <div class="form-group">
              <label for="phone_code">Phone Code</label>
              <input type="text" name="phone_code" class="form-control" id="phone_code" placeholder="Phone Code" value="{{$country->phone_code}}">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</div>


        
@endsection
@push('scripts')
<script>
let form = document.querySelector('#update');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(form);
    let url = {{route('countries.update',$country->id)}} 
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(url, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: formData
    }).then((res) => {
        return res.json();
    }).then((data) => {
        if (data.status == 'success') {
            swal.fire({
                title: "Success",
                text: "Country Updated Successfully",
                icon: "success",
                confirmButtonText: "Ok",
            }.then(() => {
                window.location.href = "{{ route('countries') }}";
            }))
        }
    })
})
</script>
@endpush