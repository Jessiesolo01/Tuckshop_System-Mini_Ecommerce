<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>

    <p>Use the link below to reset your password</p>
    <a href="{{ route("admin.reset.password", [$token, $email]) }}">Reset Password</a>
</body>
</html>