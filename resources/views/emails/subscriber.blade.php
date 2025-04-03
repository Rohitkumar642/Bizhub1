<!DOCTYPE html>
<html>
<head>
    <title>New Subscriber</title>
</head>
<body>
    <p>Hello,</p>
    <p>You have subscribed our Newsletter</p>

    <p>If you no longer wish to receive emails, you can <a href="{{ url('/unsubscribe/' .$subscriber['email']) }}" style="color:red;">unsubscribe here</a>.</p>

    <p>Thank you!</p>
</body>
</html>
