@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Create Category</h5>
          <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>
        <div class="card-body">
          <form id="store" action="{{route('categories.store')}}" type="POST">
            @csrf
            <div class="form-group">
              <label for="name"> Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="code">Code</label>
              <input type="text" name="code" class="form-control" id="code" placeholder="Code">
            </div>
            <div class="form-group">
              <label for="phone_code">Phone Code</label>
              <input type="text" name="phone_code" class="form-control" id="phone_code" placeholder="Phone Code">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</div>


        
@endsection
@push('scripts')
<script>
let form = document.querySelector('#store');
form.addEventListener('submit', (e) => {
    e.preventDefault();
    let formData = new FormData(form);
    let url = form.getAttribute('action');
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        body: formData
    }).then((res) => {
        return res.json();
    }).then((data) => {
        if (data.success) {
            swal.fire({
                title: "Success",
                text: "Category Created Successfully",
                icon: "success",
                confirmButtonText: "Ok",
            }.then(() => {
                window.location.href = "{{ route('countries') }}";
            }))
        }else{
            swal.fire({
                title: "Error",
                text: "Something went wrong",
                icon: "error",
                confirmButtonText: "Ok",
            })
        }
    })
})
</script>
@endpush