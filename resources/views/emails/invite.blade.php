<!DOCTYPE html>
<html>
<head>
    <title>Invitation</title>
</head>
<body>
    <h1>Hello, {{ $inviteeName }}!</h1>
    <p>You have been invited to join our platform. Please click the link below to accept the invitation:</p>
    <a href="{{ $inviteLink }}">Accept Invitation</a>
    <p>{{ $inviteLink }}</p>

    <p>Thank you!</p>
</body>
</html>