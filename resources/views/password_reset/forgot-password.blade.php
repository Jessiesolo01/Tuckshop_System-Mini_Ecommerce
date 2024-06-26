<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot Password</title>
</head>
<body>
    <h1>Enter your registered email</h1>
    <h3>We will send you an email with a reset password link</h3>
    <form action="{{ route('forgot.password.post') }}" method="POST">
        @csrf
        <input type="text" name="email" placeholder="Enter your email">
        <button>Submit</button>
    </form>
</body>
</html>