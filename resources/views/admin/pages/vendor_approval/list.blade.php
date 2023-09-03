@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">Vendor List</div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function runAll(){
        let deleteButtons = document.querySelectorAll('.delete-button');
        console.log(deleteButtons);
        deleteButtons.forEach((button) => {
            button.addEventListener('click', (e) => {
                let id = e.target.dataset.id;
                let url = `/admin/vendor/${id}`;
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                }).then((res) => {
                    return res.json();
                }).then((data) => {
                    if (data.status == 'success') {
                        window.location.reload();
                    }
                })
            })
        })
    }
    </script>
@endpush