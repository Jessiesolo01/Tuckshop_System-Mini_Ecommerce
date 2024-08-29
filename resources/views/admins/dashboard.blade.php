<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
</head>
<body>
    <div>
        <h1>Welcome Admin {{ $username }}</h1>
        <form action="/admin/logout" method="POST">
            @csrf
            <button>Logout</button>
        </form>
    </div>
    
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <a href="{{ route('admin.showItem')}}">View Items</a><br><br>
    <a href="{{ route('admin.addItem')}}">Add Items</a><br><br>
    <a href="{{ route('admin.showUser')}}">View Users</a><br><br>
    <a href="{{ route('admin.retrieve.receipts')}}">View Receipts</a><br><br>
    <a href="{{ route('admin.retrieve.orders')}}">View Orders</a>

</body>
</html>