<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Welcome Admin {{ $username }}</h1>
    <form action="/admin/logout" method="POST">
        @csrf
        <button>Logout</button>
    </form>
</body>
</html>