<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form action="{{ route('reset.password.post') }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="token" hidden value="{{$token}}">
        {{-- <input type="email" name="email" value="{{ old('email') }}"> --}}
        <input type="email" name="email" value="{{ $email }}">
        <input type="password" name="password" placeholder="Enter new password">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
        <button>Reset</button>
    </form>

</body>
</html>