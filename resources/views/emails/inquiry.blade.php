<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry Received</title>
</head>
<body>
    <p>Hello,</p>
    <p>We have received a new inquiry:</p>

    <p><strong>Name:</strong> {{ $inquiry['name'] }}</p>
    <p><strong>Email:</strong> {{ $inquiry['email'] }}</p>
    <p><strong>Phone:</strong> {{ $inquiry['phone'] }}</p>
    <p><strong>Message:</strong></p>
    <p>{{ $inquiry['message'] }}</p>

    <p>Thank you!</p>
</body>
</html>
