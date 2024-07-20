<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Users</title>
</head>
<body>
    <h2>List of Users</h2>
    <table>
        <tr>
            <th>User id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Wallet Balance</th>
            <th>Orders</th>
            <th>Created at</th>
            <th>Updated at</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <th>{{ $user->id }}</th>
            <th>{{ $user->name }}</th>
            <th>{{ $user->email }}</th>
            <td>{{ $user->wallet_balance }}</td>
            <td>{{ $user->orders }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
            <td><a href="{{ route('admin.editUser', [$user->id]) }}">Edit</a></td>
            <td>
                <form action="{{ route('admin.dashboard', 'id')}}" method="POST">
                    <button>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>