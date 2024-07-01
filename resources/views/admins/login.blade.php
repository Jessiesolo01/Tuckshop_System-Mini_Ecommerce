<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
</head>
<body>
    <h1>Admin Login</h1>
    <form action="{{ route('admin.login.post') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <button>Admin Login</button>
        <br>
        <br>
        <a href="{{ route('admin.forgot.password') }}">Forgot password?</a><br>
    </form>
</body>
</html>