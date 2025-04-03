@extends('layouts.app')

@section('content')
<div class="containers mt-2">
    <div class="main_header_logo">
        <figure>
            <a href="#" title="Bizhub India"><img src="img/bizhub-india-logo.png" alt="logo" style=""></a>                        
        </figure>
    </div>
    
    <h4>Vendor Registration Form</h4>
    <form id="vendorForm" enctype="multipart/form-data" method="post">
        @csrf  {{-- Laravel CSRF Protection --}}

        <!-- GST Selection -->
        <div class="mb-3">
            <label class="form-label">Do you have a GST Number?</label>
            <select class="form-control" id="gst_option" name="gst_option">
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </div>

        <div id="details">
            <!-- Vendor Name -->
            <div class="mb-1" id="company_name">
                <label class="form-label" for="vendor_name">Company Name</label>
                <input type="text" class="form-control" id="vendor_name" name="vendor_name" placeholder="Legal Company Name" required>
            </div>

            <!-- Email -->
            <div class="mb-1">
                <label class="form-label" for="vendor_email">Email</label>
                <input type="email" class="form-control" id="vendor_email" name="vendor_email" placeholder="Enter Email" required>
            </div>
        </div>

        <!-- GST Number -->
        <div class="mb-1" id="gstField">
            <label class="form-label" for="gst_no">GST Number</label>
            <input type="text" class="form-control" id="gst_no" name="gst_no" placeholder="Enter GST Number" required>
        </div>

        <!-- Fetch Vendor Details Button -->
        <button type="button" id="fetchBtn">Fetch Vendor Details</button>

        <!-- Vendor Details Section -->
        <div id="vendorDetails" class="mt-4" style="display:none;">
            <h3>Vendor Information</h3>
            <p><strong>GST Number:</strong> <span id="gst-no"></span></p>
            <p><strong>Legal Name:</strong> <span id="legal-name"></span></p>
            <p><strong>Registration Date:</strong> <span id="registration"></span></p>
            <p><strong>Trade Name:</strong> <span id="trade-name"></span></p>
            <p><strong>Company Type:</strong> <span id="company-type"></span></p>
            <p><strong>Duty:</strong> <span id="duty"></span></p>
            <p><strong>Status:</strong> <span id="status"></span></p>
            <p><strong>Nature of Business:</strong> <span id="nature-business"></span></p>
            <p><strong>Address:</strong> <span id="address"></span></p>
            <p><strong>District:</strong> <span id="district"></span></p>
            <p><strong>State:</strong> <span id="state"></span></p>
            <p><strong>Pin Code:</strong> <span id="pin-code"></span></p>
            <p><strong>Email:</strong> <span id="vendor-email"></span></p>

            <!-- Register Button -->
            <button type="button" id="registerBtn">Register</button>
        </div>

        <div id="manualVendorDetails" class="mt-2" style="display:none;">
            <h3>Enter Your Business Details</h3>

            <div class="mb-3">
                <label class="form-label" for="email">Official Email ID</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Registered email id" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="legal_name">Legal Name</label>
                <input type="text" class="form-control" id="legal_name" name="legal_name" placeholder="Registered Company Name" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="duty">Duty</label>
                <input type="text" class="form-control" id="duty1" name="duty" placeholder="Regular / Protective" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="registration">Registration Date</label>
                <input type="text" class="form-control" id="registration1" name="registration" placeholder="DD/MM/YYYY" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="company_type">Company Type</label>
                <input type="text" class="form-control" id="company_type" name="company_type" placeholder="Private / Public / Partnership" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="status">Status</label>
                <input type="text" class="form-control" id="status1" name="status" placeholder="Active / Inactive" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="trade_name">Trade Name</label>
                <input type="text" class="form-control" id="trade_name" name="trade_name" placeholder="Registered Trade Name" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="nature">Nature of Business</label>
                <input type="text" class="form-control" id="nature" name="nature" placeholder="Core Business Activity" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="address">Address</label>
                <input type="text" class="form-control" id="address1" name="address" placeholder="Location Of Office" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="district">District</label>
                <input type="text" class="form-control" id="district1" name="district" placeholder="District in which office Located" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="state">State</label>
                <input type="text" class="form-control" id="state1" name="state" placeholder="State in which Office Located" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="pin_code">Pin Code</label>
                <input type="text" class="form-control" id="pin_code" name="pin_code" placeholder="Office's Pin Code" required>
            </div>

            <button type="button" id="registerManualBtn">Register</button>
        </div>

        <div id="otpSection" style="display: none;">
        @csrf
        <p>You have recieved OTP to your entered Email ID</p>
            <h5>OTP</h5>
            <input type="text" id="otpInput" class="form-control" placeholder="Enter OTP">
            <button id="verifyOtpBtn">Verify OTP</button>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#vendor_name').on('input', function() {
            var inputVal = $(this).val();
            $(this).val(inputVal.toUpperCase());
        });

        $('#gst_no').on('input', function() {
            var inputVal = $(this).val();
            $(this).val(inputVal.toUpperCase());
        });

        $('#legal_name').on('input', function() {
            var inputVal = $(this).val();
            $(this).val(inputVal.toUpperCase());
        });

        $('#trade_name').on('input', function() {
            var inputVal = $(this).val();
            $(this).val(inputVal.toUpperCase());
        });

        $('#gst_option').change(function () {
            if ($(this).val() === 'no') {
                $('#gstField').hide();
                $('#fetchBtn').hide();
                $('#details').hide();
                $('#manualVendorDetails').show();
            } else {
                $('#gstField').show();
                $('#fetchBtn').show();
                $('#details').show();
                $('#vendorDetails').hide();
                $('#manualVendorDetails').hide();
            }
        });

        $('#vendor_email').on('blur', function () {
            var email = $(this).val();

            // Check if the email ends with @gmail.com
            
            if (!email.includes('@')) {
                alert('Please enter a valid email address that contains @');
                $(this).val(''); // Clear the input field
            }
        });

        $('#email').on('blur', function () {
            var email = $(this).val();

            // Check if the email ends with @gmail.com
           
            if (!email.includes('@')) {
                alert('Please enter a valid email address that contains @');
                $(this).val(''); // Clear the input field
            }
        });

        $('#duty1').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#company_type').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#status1').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#trade_name').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#district1').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#state1').on('input', function () {
            // Replace anything that is not a letter with an empty string
            var inputVal = $(this).val();
            var alphabetOnly = inputVal.replace(/[^a-zA-Z\s]/g, '');  // This allows spaces too
            $(this).val(alphabetOnly);
        });

        $('#registration1').on('input', function () {
            // Replace anything that is not a digit or special characters (such as hyphens, spaces) with an empty string
            var inputVal = $(this).val();
            var validInput = inputVal.replace(/[^0-9\-\/\s]/g, '');  // This allows digits, hyphen, and spaces
            $(this).val(validInput);
        });

        $('#pin_code').on('input', function () {
            // Replace anything that is not a digit or special characters (such as hyphens, spaces) with an empty string
            var inputVal = $(this).val();
            if (/[a-zA-Z]/.test(inputVal)) {
                alert('Only numbers are allowed in the PIN code.');
            }
            var validInput = inputVal.replace(/[^0-9\-\s]/g, '');  // This allows digits, hyphen, and spaces
            $(this).val(validInput);
        });

        $('#fetchBtn').click(function() {
            var gst_no = $('#gst_no').val();
            var vendor_name = $('#vendor_name').val();
            var email_vendor = $('#vendor_email').val();

            if (!vendor_name) {
                alert('Please enter Company Legal Name.');
                return;
            }

            if (!email_vendor) {
                alert('Please enter Email.');
                return;
            }

            if (!gst_no) {
                alert('Please enter GST Number.');
                return;
            }

            $.ajax({
                url: "{{ route('fetch.vendor.data') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    gst_no: gst_no,
                    vendor_name: vendor_name,
                    vendor_email: email_vendor
                },
                success: function(response) {
                    if (response.status) {
                        $('#vendorDetails').show();
                        $('#legal-name').text(response.data.legal_name);
                        $('#state').text(response.data.state);
                        $('#duty').text(response.data.duty);
                        $('#gst-no').text(response.data.gst_no);
                        $('#registration').text(response.data.registration);
                        $('#company-type').text(response.data.company_type);
                        $('#status').text(response.data.status);
                        $('#trade-name').text(response.data.trade_name);
                        $('#nature-business').text(response.data.nature_business);
                        $('#address').text(response.data.address);
                        $('#district').text(response.data.district);
                        $('#pin-code').text(response.data.pin_code);
                        $('#vendor-email').text(response.data.vendor_email);
                    } else {
                        alert(response.message);
                        $('#vendorDetails').hide();
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        $('#registerBtn').click(function() {
            var vendor_email = $('#vendor-email').text();

            $.ajax({
                url: "{{ route('register.vendor') }}",
                type: 'POST',
                data: { _token: "{{ csrf_token() }}", vendor_email: vendor_email },
                success: function(response) {
                    if (response.status) {
                        alert(response.message);
                        $('#registerBtn').hide();
                        $('#otpSection').show();
                    } else {
                        alert(response.message);
                    }
                },
            });
        });

        $('#registerManualBtn').click(function() {
            var legal_name = $('#legal_name').val().trim();
            var email_vendor = $('#email').val().trim();
            var duty = $('#duty1').val().trim();
            var registration = $('#registration1').val().trim();
            var company_type = $('#company_type').val().trim();
            var status = $('#status1').val().trim();
            var trade_name = $('#trade_name').val().trim();
            var nature_business = $('#nature').val().trim();
            var address = $('#address1').val().trim();
            var district = $('#district1').val().trim();
            var state = $('#state1').val().trim();
            var pin_code = $('#pin_code').val().trim();

            if (!legal_name) {
                alert('Please enter Company Legal Name.');
                return;
            }
            if(!vendor_email) {
                alert('Please enter email id.');
                return;
            }
            if(!duty) {
                alert('Please enter duty type.');
                return;
            }
            if(!registration) {
                alert('Please enter registration date.');
                return;
            }
            if(!company_type) {
                alert('Please enter company type.');
                return;
            }
            if(!status) {
                alert('Please enter status.');
                return;
            }
            if(!trade_name) {
                alert('Please enter trade name.');
                return;
            }
            if(!nature_business) {
                alert('Please enter business nature.');
                return;
            }
            if(!address) {
                alert('Please enter address.');
                return;
            }
            if(!district) {
                alert('Please enter district.');
                return;
            }
            if(!state) {
                alert('Please enter state.');
                return;
            }
            if(!pin_code) {
                alert('Please enter pin code.');
                return;
            }
            
            var manualData = {
                legal_name: $('#legal_name').val(),
                vendor_email: $('#email').val(),
                duty: $('#duty1').val(),
                registration: $('#registration1').val(),
                company_type: $('#company_type').val(),
                status: $('#status1').val(),
                trade_name: $('#trade_name').val(),
                nature_business: $('#nature').val(),
                address: $('#address1').val(),
                district: $('#district1').val(),
                state: $('#state1').val(),
                pin_code: $('#pin_code').val(),
            }

            $.ajax({
                url: "{{ route('register.vendormanual') }}",
                type: 'POST',
                data: manualData,
                success: function(response) {
                    //var data = JSON.parse(response);
                    if(response.status){
                        alert(response.message);
                        //alert('Vendor registered successfully.');
                        window.location.href = response.redirect;
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('An error occured while registering.');
                }
            });
        });

    $('#verifyOtpBtn').click(function () {
        var otp = $('#otpInput').val();
        var vendor_email = $('#vendor-email').text();

        $.ajax({
            url: "{{ route('verify.otp') }}",
            type: 'POST',
            data: { 
                vendor_email: vendor_email, 
                otp: otp, 
                _token: "{{ csrf_token() }}" // Include CSRF token
            },
            success: function (response) {
                if (response.status) {
                    alert(response.message);
                    window.location.href = response.redirect; // Redirect to home page
                } else {
                    alert(response.message);
                }
            },
            error: function (xhr) {
                alert('Something went wrong. Please try again.');
            }
        });
    });
});

</script>
@endsection
