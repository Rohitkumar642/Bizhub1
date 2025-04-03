<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login With Mobile</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color:rgb(93, 92, 92);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        .message {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="main_header_logo">
        <figure>
            <a href="#" title="Bizhub India"><img src="img/bizhub-india-logo.png" alt="logo" style=""></a>                        
        </figure>
    </div>

    <h3>Login With Mobile Number</h3>

    <form id="otpForm">
        <label for="mobileNumber">Enter Mobile Number:</label>
        <input type="text" id="mobileNumber" name="mobileNumber" placeholder="Your Mobile Number" required>
        <button type="button" id="sendOtpBtn">Send OTP</button>

        <div id="otpSection" style="display: none;">
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            <button type="button" id="verifyOtpBtn">Verify OTP</button>
        </div>
    </form>
    <div id="message" class="message"></div>

    <div id="signupsection">
        <label for="otp">Don't have account.</label>
        <button type="button" id="signupBtn">SignUp</button>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#mobileNumber').on('input', function () {
            var inputVal = $(this).val();
            var validInput = inputVal.replace(/[^0-9\-\s]/g, ''); 
            $(this).val(validInput);
        });

        $('#sendOtpBtn').click(function() {
            const mobileNumber = $('#mobileNumber').val();
            const messageDiv = $('#message');

            if (!/^[0-9]{10}$/.test(mobileNumber)) {
                messageDiv.css('color', 'red').text('Please enter a valid 10-digit mobile number.');
                return;
            }

            $.ajax({
                url: '{{ route("send.otp") }}',
                type: 'POST',
                data: { 
                    mobile: mobileNumber, 
                    _token: '{{ csrf_token() }}' 
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        messageDiv.css('color', 'green').text(response.message);
                        $('#otpSection').show();
                    } else {
                        messageDiv.css('color', 'red').text(response.message);
                    }
                }
            });
        });

        $('#verifyOtpBtn').click(function() {
            const mobileNumber = $('#mobileNumber').val();
            const otp = $('#otp').val();
            const messageDiv = $('#message');

            $.ajax({
                url: '{{ route("verify.otpmobile") }}',
                type: 'POST',
                data: { 
                    mobile: mobileNumber, 
                    otp: otp, 
                    _token: '{{ csrf_token() }}' 
                },
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        messageDiv.css('color', 'green').text(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect; 
                        }, 1000);
                    } else {
                        messageDiv.css('color', 'red').text(response.message);
                    }
                }
            });
        });

        $('#signupBtn').click(function() {
            window.location.href = '/signup'; 
        });
    });
</script>

</body>
</html>
