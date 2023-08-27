@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-between">
                <h3>Vendor Approval</h3>
                <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Vendor Details</div>
                    <div class="card-body">
                        @foreach ($vendor_details as $key => $item)
                            <div class="row detail-row">
                                <div class="col-6">
                                    <p class="detail-head">{{ $item }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-value">
                                        {{ $vendor->$key }}
                                    </p>
                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">User Details</div>
                    <div class="card-body">
                        @foreach ($user_details as $key => $item)
                            <div class="row detail-row">
                                <div class="col-6">
                                    <p class="detail-head">{{ $item }}</p>
                                </div>
                                <div class="col-6">
                                    <p class="detail-value">
                                        {{ $user->$key }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Category Details</div>
                    <div class="card-body">
                        <div class="row detail-header-row">
                            <div class="col-6">
                                <div class="detail-head">Category</div>
                            </div>
                            <div class="col-6">
                                <div class="detail-head">Sub Category</div>
                            </div>
                        </div>
                        @foreach ($category as $item)
                            <div class="row detail-row">
                                <div class="col-6">
                                    <div class="detail-value">{{ $item['name'] }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="detail-value">{{ $item['sub_categories'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-header">Logo and Signature</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="detail-head">Logo</div>
                                <div class="detail-value">
                                    <img src="{{ $vendor->logo }}" alt="" class="img-fluid">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-head">Signature</div>
                                <div class="detail-value">
                                    <img src="{{ $vendor->signature }}" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-2">
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-success approve" data-status=approve>Approve</button>
                    <button type="button" class="btn btn-danger approve" data-status="reject">Reject</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('button.approve').forEach(function(button) {
            button.addEventListener('click', function() {
                let status = button.getAttribute('data-status');
                let id = "{{ $vendor->id }}"
                let url = "{{ route('vendor.approve-store') }}";
                let redirect_url = "{{ route('vendor.approve') }}";
                let data = {
                    id: id,
                    status: status
                };
                axios.post(url, data).then(function(response) {
                    if (response.data.success) {
                        // show swal alert
                        swal.fire(
                            'Success',
                            response.data.message,
                            'success'
                        ).then(function() {
                            window.location.href = redirect_url;
                        });
                    }
                    
                }).catch(function(error) {
                    console.log(error);
                });
            });

        });
    </script>
@endpush
