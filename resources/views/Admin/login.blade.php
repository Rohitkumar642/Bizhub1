<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
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
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 400px;">
            <div class="main_header_logo">
                <figure>
                    <a href="#" title="Bizhub India"><img src="img/bizhub-india-logo.png" alt="logo" style=""></a>                        
                </figure>
            </div>
            <h3 class="text-center mb-3">Admin Login</h3>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit">Login</button>
            </form>

            <div id="forgot">
            <p>Forgot Password (Click on reset password button)</p>
            <button type="button" id="reset_password_btn">Reset Password</button>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#reset_password_btn').click(function() {
            var email = $('input[name="email"]').val(); // Get email from the login form

            if (email === '') {
                alert('Please enter your email');
                return;
            }

            $.ajax({
                url: "{{ route('admin.reset.password') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    email: email
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert(xhr.responseJSON.message);
                }
            });
        });
    });
</script>

</html>
