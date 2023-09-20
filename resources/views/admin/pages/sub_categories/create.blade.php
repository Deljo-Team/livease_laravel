@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h5>Create Sub Category</h5>
          <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </div>
        <div class="card-body">
          <form id="store" action="{{route('sub_categories.store')}}" type="POST">
            @csrf
            <div class="form-group">
              <label for="name"> Name</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name">
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select  name="category" class="form-control" id="category" placeholder="Category" >
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                <option value="{{$category->id}}" >{{$category->name}}</option>
                @endforeach
              </select>            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
    </div>
</div>


        
@endsection
@push('scripts')
<script>
//load the script after the page is loaded
window.addEventListener('load', function() {
            let form = document.getElementById("store");
            form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    var formData = new FormData(e.target);

                    const form_data = Object.fromEntries(formData.entries());

                    // You now have the form data as a JSON object

                    let url = "{{ route('sub_categories.store')}}"
                    admin.sendRequest(url, 'POST', form_data).then((response) => {
                            const data = response.data;
                            if (data.success) {
                                swal.fire({
                                    title: "Success",
                                    text: "Sub Category Created Successfully",
                                    icon: "success",
                                    confirmButtonText: "Ok",
                                }).then(() => {
                                    window.location.href = "{{ route('sub_categories') }}";
                                })
                        } else {
                            swal.fire({
                                title: "Error",
                                text: data.message,
                                icon: "error",
                                confirmButtonText: "Ok",
                            })
                        }
                    }).catch(function(error) {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                        message = error.response.data.message;
                        swal.fire({
                            title: "Error",
                            text: message,
                            icon: "error",
                            confirmButtonText: "Ok",
                        })
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        swal.fire({
                            title: "Error",
                            text: "Something went wrong",
                            icon: "error",
                            confirmButtonText: "Ok",
                        })
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        swal.fire({
                            title: "Error",
                            text: "Something went wrong",
                            icon: "error",
                            confirmButtonText: "Ok",
                        })
                    }
                    console.log(error.config);
                });;
            });
});
</script>
@endpush