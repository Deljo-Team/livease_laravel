@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Edit Country</h5>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
            <div class="card-body">
                <form id="update" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name"> Name</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name"
                            value="{{ $country->name }}">
                    </div>
                    <div class="form-group">
                        <label for="code">Code</label>
                        <input type="text" name="code" class="form-control" id="code" placeholder="Code"
                            value="{{ $country->code }}">
                    </div>
                    <div class="form-group">
                        <label for="phone_code">Phone Code</label>
                        <input type="text" name="phone_code" class="form-control" id="phone_code"
                            placeholder="Phone Code" value="{{ $country->phone_code }}">
                    </div>
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
            let form = document.getElementById("update");
            form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    var formData = new FormData(e.target);

                    const form_data = Object.fromEntries(formData.entries());

                    // You now have the form data as a JSON object

                    let url = "{{ route('countries.update', $country->id) }}"
                    admin.sendRequest(url, 'PUT', form_data).then((response) => {
                            const data = response.data;
                            console.log(data)
                            if (data.success) {
                                swal.fire({
                                    title: "Success",
                                    text: "Country Updated Successfully",
                                    icon: "success",
                                    confirmButtonText: "Ok",
                                }).then(() => {
                                    window.location.href = "{{ route('countries.index') }}";
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
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('Error', error.message);
                    }
                    console.log(error.config);
                });
            })
        });
    </script>
