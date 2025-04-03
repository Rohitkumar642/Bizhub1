@extends('admin.layout')

@section('content')
<div class="container">
    <h3>Welcome to Admin Dashboard</h3>
    <p>This is your custom dashboard view.</p>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <p class="card-text">{{ $totalUser ?? 0}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Vendors</h5>
                    <p class="card-text">{{ $totalVendors ?? 0}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Subscribers</h5>
                    <p class="card-text">{{ $totalSubscribers ?? 0}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Unsubscribers</h5>
                    <p class="card-text">{{ $totalUnSubscribers ?? 0}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Enquiries</h5>
                    <p class="card-text">{{ $totalEnquiries ?? 0}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#editProfileBtn').click(function (e) {
            e.preventDefault();
            $('.container.mt-3').load("{{ route('admin.editProfile') }}");
        });
    });
</script>

@endsection
