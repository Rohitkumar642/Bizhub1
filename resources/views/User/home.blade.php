@extends('user.layout')

@section('content')
<div class="container mt-5">
       
        @if($vendors->isEmpty())
            <div class="alert alert-warning text-center">
                No vendor found for this email.
            </div>
        @else
            <div class="row">
                @foreach($vendors as $vendor)
                    <div class="col-md-4">
                        <div class="vendor-card">
                            <div class="vendor-header">
                                <h5>{{ $vendor->legal_name }}</h5>
                            </div>
                            <div class="vendor-info">
                                <p><strong>GST No:</strong> {{ $vendor->gst_no ? $vendor->gst_no : 'Not Available' }}</p>
                                <p><strong>Email:</strong> {{ $vendor->vendor_email }}</p>
                                <p><strong>Registration Date:</strong> {{ $vendor->registration }}</p>
                                <p><strong>Duty:</strong> {{ $vendor->duty }}</p>
                                <p><strong>Company Type:</strong> {{ $vendor->company_type }}</p>
                                <p><strong>Status:</strong> {{ $vendor->status }}</p>
                                <p><strong>Trade Name:</strong> {{ $vendor->trade_name }}</p>
                                <p><strong>Nature of Business:</strong> {{ $vendor->nature_business }}</p>
                                <p><strong>Address:</strong> {{ $vendor->address }}</p>
                                <p><strong>District:</strong> {{ $vendor->district }}</p>
                                <p><strong>State:</strong> {{ $vendor->state }}</p>
                                <p><strong>Pin Code:</strong> {{ $vendor->pin_code }}</p>

                                <!-- Edit Button -->
                                <button class="btn btn-primary btn-sm editVendorBtn" 
                                    data-id="{{ $vendor->id }}"
                                    data-legal_name="{{ $vendor->legal_name }}"
                                    data-gst_no="{{ $vendor->gst_no }}"
                                    data-vendor_email="{{ $vendor->vendor_email }}"
                                    data-registration="{{ $vendor->registration }}"
                                    data-duty="{{ $vendor->duty }}"
                                    data-company_type="{{ $vendor->company_type }}"
                                    data-status="{{ $vendor->status }}"
                                    data-trade_name="{{ $vendor->trade_name }}"
                                    data-nature_business="{{ $vendor->nature_business }}"
                                    data-address="{{ $vendor->address }}"
                                    data-district="{{ $vendor->district }}"
                                    data-state="{{ $vendor->state }}"
                                    data-pin_code="{{ $vendor->pin_code }}">
                                    Edit Profile
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Edit Vendor Modal -->
    <div class="modal fade" id="editVendorModal" tabindex="-1" aria-labelledby="editVendorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVendorModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editVendorForm">
                        @csrf
                        <input type="hidden" id="vendor_id" name="vendor_id">

                        <div class="form-group">
                            <label>Legal Name</label>
                            <input type="text" class="form-control" id="legal_name" name="legal_name">
                        </div>

                        <div class="form-group">
                            <label>GST No</label>
                            <input type="text" class="form-control" id="gst_no" name="gst_no">
                        </div>

                        <div class="form-group">
                            <label>Duty</label>
                            <input type="text" class="form-control" id="duty" name="duty">
                        </div>

                        <div class="form-group">
                            <label>Registration</label>
                            <input type="text" class="form-control" id="registration" name="registration">
                        </div>

                        <div class="form-group">
                            <label>Company Type</label>
                            <input type="text" class="form-control" id="company_type" name="company_type">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <input type="text" class="form-control" id="status" name="status">
                        </div>

                        <div class="form-group">
                            <label>Trade Name</label>
                            <input type="text" class="form-control" id="trade_name" name="trade_name">
                        </div>

                        <div class="form-group">
                            <label>Nature of Business</label>
                            <input type="text" class="form-control" id="nature_business" name="nature_business">
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>

                        <div class="form-group">
                            <label>District</label>
                            <input type="text" class="form-control" id="district" name="district">
                        </div>

                        <div class="form-group">
                            <label>State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>

                        <div class="form-group">
                            <label>Pin Code</label>
                            <input type="number" class="form-control" id="pin_code" name="pin_code">
                           </div>
                        <input type="hidden" id="vendor_email" name="vendor_email">


                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
    $(document).ready(function () {
        $(".editVendorBtn").click(function () {
                $("#vendor_id").val($(this).data("id"));
                $("#legal_name").val($(this).data("legal_name"));
                $("#gst_no").val($(this).data("gst_no"));
                $("#vendor_email").val($(this).data("vendor_email"));
                $("#registration").val($(this).data("registration"));
                $("#duty").val($(this).data("duty"));
                $("#company_type").val($(this).data("company_type"));
                $("#status").val($(this).data("status"));
                $("#trade_name").val($(this).data("trade_name"));
                $("#nature_business").val($(this).data("nature_business"));
                $("#address").val($(this).data("address"));
                $("#district").val($(this).data("district"));
                $("#state").val($(this).data("state"));
                $("#pin_code").val($(this).data("pin_code"));

                $("#editVendorModal").modal("show");
            });

            $("#editVendorForm").submit(function (e) {
                e.preventDefault();
                let formData = $(this).serialize();
                
                $.ajax({
                    type: "POST",
                    url: "{{ route('update.vendor') }}",
                    data: formData,
                    success: function (response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function (xhr) {
                        alert("Error updating vendor. Please try again.");
                    }
                });
            });
    })
</script>
@endsection