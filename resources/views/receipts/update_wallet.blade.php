<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Wallet</title>
</head>
<body>
    <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a><br><br>

    @if ($no_of_receipts != 0)
    <h3>Pending Confirmations</h3>
        <table>
            <tr>
                <th>Receipt id</th>
                <th>Uploaded by</th>
                <th>Uploaded at</th>
                <th>File</th>
            </tr>
            @foreach($receipts as $receipt)
            <tr>
                <th>{{ $receipt->id }}</th>
                <th>{{ $receipt->uploaded_by }}</th>
                <th>{{ $receipt->created_at }}</th>
                <td>{{ $receipt->file }}</td>
                {{-- <td><a href="{{ route('view.receipt', [$id]) }}">View</a></td> --}}
                <td>
                    <form action="{{ route('view.receipt', [$receipt->id])}}" method="GET">
                        @csrf
                        <button>View</button>
                    </form>
                </td>
                    
                <td>
                    <form action="{{ route('delete.receipt', [$receipt->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @endif

<br>
    <h3>Make a Transfer</h3>
    <p>To Update Wallet balance,</p>
    <p>Make a Transfer to Account no: 0767082875</p> 
    <p>Bank Name: Access bank</p>
    <p>Account Name: Jessica Onini Solomon</p>
    <p>and upload your reciept for confirmation and update</p>
    <h1>Wallet Balance: {{ $wallet_balance }}</h1>
    <br>
    <h3>Upload New Receipt</h3>
    <form action="{{ url('/update-wallet/'.$id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="id" value="{{ $id }}" hidden>
        <input type="text" name="user_name" value="{{ $username }}" hidden>
        <input type="file" name="file">
        <button>Submit</button>
    </form>
</body>
</html>