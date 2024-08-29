<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Users</title>
</head>
<body>
    <a href="{{ url('/admin/dashboard/'.$admin_id) }}">Return to dashboard</a><br><br>
    <a href="{{ route('admin.showUser') }}">Users</a><br><br>

    @if ($no_of_users != 0)
    <form action="{{ route('admin.search.user') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="Enter User ID, Email or Name">
        <button>Search</button>
    </form><br>
    <h2>List of Users</h2>
    <table>
        <tr>
            <th style="border: 1px solid black;">User id</th>
            <th style="border: 1px solid black;">Name</th>
            <th style="border: 1px solid black;">Email</th>
            <th style="border: 1px solid black;">Wallet Balance</th>
            <th style="border: 1px solid black;">Orders</th>
            <th style="border: 1px solid black;">Created at</th>
            <th style="border: 1px solid black;">Updated at</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td style="border: 1px solid black;">{{ $user->id }}</td>
            <td style="border: 1px solid black;">{{ $user->name }}</td>
            <td style="border: 1px solid black;">{{ $user->email }}</td>
            <td style="border: 1px solid black;">{{ $user->wallet_balance }}</td>
            <td style="border: 1px solid black;">{{ $user->orders }}</td>
            <td style="border: 1px solid black;">{{ $user->created_at }}</td>
            <td style="border: 1px solid black;">{{ $user->updated_at }}</td>
            <td style="border: 1px solid black;"><a href="{{ route('admin.editUser', [$user->id]) }}">Edit</a></td>
            <td style="border: 1px solid black;">
                <form action="{{ route('admin.dashboard', 'id')}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @else
        <p>Users Table Empty</p>
    @endif
</body>
</html>