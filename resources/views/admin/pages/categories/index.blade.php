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
                button.addEventListener("click", (e) => {
                    swal
                        .fire({
                            title: "Do you want to Delete?",
                            showDenyButton: true,
                            // showCancelButton: true,
                            confirmButtonText: "Yes",
                            denyButtonText: "No",
                            customClass: {
                                actions: "my-actions",
                                cancelButton: "order-1 right-gap",
                                confirmButton: 'order-2',
                                // denyButton: 'order-3',
                            },
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                let id = e.target.dataset.id;
                                let url = "{{ route("countries.destroy",'id') }}";
                                url = url.replace('id',id);
                                let token = document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute("content");
                                fetch(url, {
                                        method: "DELETE",
                                        headers: {
                                            "X-CSRF-TOKEN": token,
                                        },
                                    })
                                    .then((res) => {
                                        return res.json();
                                    })
                                    .then((data) => {
                                        if (data.status == "success") {
                                            window.location.reload();
                                        }
                                    });
                            }
                        });
                });
            });
        }
    </script>
@endpush
