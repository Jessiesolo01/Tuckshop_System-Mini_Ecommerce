<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit User</title>
</head>
<body>
    {{-- <a href="{{ url('/admin/dashboard/'.$id) }}">Return to dashboard</a><br><br> --}}

    <h1>Edit User</h1>
    <form action="{{ url('/admin/update-user/'.$user->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- <input type="text" name="id" placeholder="I.D" value="{{ $user->id }}"> --}}
        <label for="id" style="font-weight: bold">User Id:  {{ $user->id }}</label><br><br>
        <label for="name" style="font-weight: bold">Name</label>
        <input type="text" name="name" placeholder="Name" value="{{ $user->name }}"><br><br>
        <label for="email"style="font-weight: bold">Email</label>
        <input type="text" name="email" placeholder="Email" value="{{ $user->email }}"><br><br>
        <label for="wallet_balance"style="font-weight: bold">Wallet Balance</label>
        <p>{{ $user->wallet_balance }}</p>
        <label for="orders" style="font-weight: bold">Available orders</label>
        <input type="text" name="orders" placeholder="Available Orders" value="{{ $user->orders }}"><br><br>
        <input type="text" name="updated_by" value="{{ $username }}" hidden>
        {{-- <input type="text" name="wallet_balance" placeholder="Wallet balance" value="{{ $user->wallet_balance }}"> --}}
        {{-- <input type="text" name="orders" placeholder="No. of orders" value="{{ $user->orders }}"> --}}
        <button>Update User</button>
    </form>
</body>
</html>