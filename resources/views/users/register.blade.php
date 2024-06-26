<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h1>Create an Account</h1>
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Enter your full name">
        <input type="text" name="email" placeholder="Enter your email">
        <input type="password" name="password" placeholder="Enter your password">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
        <button>Register</button>
        <br>
        <br>
        <a href="{{ route('login') }}">Already created an account?</a>
    </form>
</body>
</html>