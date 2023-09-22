@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Categories</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function runAll() {

            let deleteButtons = document.querySelectorAll(".delete-button");
            deleteButtons.forEach((button) => {
                var url = button.dataset.url;
                button.addEventListener("click", (e) => {
                    swal
                        .fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!',
                            cancelButtonText: 'No, cancel!',
                            reverseButtons: true
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                // let id = e.target.dataset.id;

                                admin.sendRequest(url, 'DELETE').then((response) => {
                                    const data = response.data;
                                    console.log(data)
                                    if (data.success) {
                                        swal.fire({
                                            title: "Success",
                                            text: "Category Deleted Successfully",
                                            icon: "success",
                                            confirmButtonText: "Ok",
                                        }).then(() => {
                                            window.location.href =
                                                "{{ route('category.index') }}";
                                        })
                                    }
                                });
                            }
                        });
                });
            });
        }
    </script>
@endpush
