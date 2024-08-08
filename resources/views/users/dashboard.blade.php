<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
<div>
    <h1>Welcome {{$username}}</h1>
    <a href="{{ route('create.order')}}">Place An Order</a><br>
    <a href="{{ url('/cart/'.$id) }}">Cart</a>
    <form action="/logout" method="POST">
        @csrf
        <button>Logout</button>
    </form>
</div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
</body>
</html>