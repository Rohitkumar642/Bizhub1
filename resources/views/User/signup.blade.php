<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
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
            margin-top: 10px;
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

    <h3>Signup Form</h3>

    <form id="signupForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter Email" required>

        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile" placeholder="Enter Mobile Number" required maxlength="10">

        <button type="submit">Signup</button>
    </form>

    <div id="otpsection" style="display: none">
        <label for="otp">OTP:</label>
        <input type="text" id="otp" name="otp" placeholder="Enter OTP">
        <button type="button" id="verifyOtpBtn">Verify OTP</button>
    </div>

    <button type="button" id="loginBtn" style="display: none">Login</button>

    <p id="message"></p>
</div>

    <script>
        $(document).ready(function() {
            $('#signupForm').submit(function(event) {
                event.preventDefault(); // Prevent form submission

                $.ajax({
                    url: "/signup",
                    type: "POST",
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        mobile: $('#mobile').val(),
                        _token: "{{ csrf_token() }}" // Include CSRF token
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#otpsection').show();
                            $('#message').text("OTP Sent Successful!").css("color", "green");
                        } else {
                            $('#message').text(response.message).css("color", "red");
                            $('#loginBtn').show();
                        }
                    },
                    error: function(xhr) {
                        $('#loginBtn').show();
                        $('#message').text("Already Have Account with this Email. Please Login.").css("color", "red");
                    }
                });
            });

            $('#verifyOtpBtn').click(function() {
                $.ajax({
                    url: "/checkotp",
                    type: "POST",
                    data: {
                        mobile: $('#mobile').val(),
                        otp: $('#otp').val(),
                        _token: "{{ csrf_token() }}" // Include CSRF token
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#message').text("OTP Verified! Redirecting...").css("color", "green");
                            setTimeout(function() {
                                window.location.href = '/vendor';
                            }, 2000);
                        } else {
                            $('#message').text("Invalid OTP. Please try again.").css("color", "red");
                        }
                    },
                    error: function(xhr) {
                        $('#message').text("Error: " + xhr.responseJSON.message).css("color", "red");
                    }
                });
            });

            $('#loginBtn').click(function() {
                window.location.href = '/login'; 
            });
        });
    </script>

</body>
</html>
