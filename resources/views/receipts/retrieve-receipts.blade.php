<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Wallet</title>
</head>
<body>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <br><br>
    <a href="{{ url('/admin/dashboard/'.$admin_id) }}">Return to dashboard</a><br><br>
    <a href="{{ route('admin.retrieve.receipts') }}">Receipts</a><br><br>

    @if ($no_of_receipts != 0)
    <form action="{{ route('admin.search.receipt') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="Enter Item ID, Item Name, Price, No in stock, Created By or Updated By" style="width: 500px">
        <button>Search</button>
    </form><br>
    <h1>List of Receipts</h1>
        <table>
            <tr>
                <th style="border: 1px solid black;">Receipt id</th>
                <th style="border: 1px solid black;">User Id</th>
                <th style="border: 1px solid black;">Username</th>
                <th style="border: 1px solid black;">Uploaded by</th>
                <th style="border: 1px solid black;">Uploaded at</th>
                <th style="border: 1px solid black;">Updated by</th>
                <th style="border: 1px solid black;">Updated at</th>
                <th style="border: 1px solid black;">File</th>
            </tr>
            @foreach($receipts as $receipt)
            <tr>
                <td style="border: 1px solid black;">{{ $receipt->id }}</td>
                <td style="border: 1px solid black;">{{ $receipt->user_id }}</td>
                <td style="border: 1px solid black;">{{ $receipt->user_name }}</td>
                <td style="border: 1px solid black;">{{ $receipt->uploaded_by }}</td>
                <td style="border: 1px solid black;">{{ $receipt->created_at }}</td>
                <td style="border: 1px solid black;">{{ $receipt->updated_by }}</td>
                <td style="border: 1px solid black;">{{ $receipt->updated_at }}</td>
                <td style="border: 1px solid black;">{{ $receipt->file }}</td>
                {{-- <td><a href="{{ route('view.receipt', [$id]) }}">View</a></td> --}}
                <td style="border: 1px solid black;">
                    <form action="{{ route('admin.view.receipt', [$receipt->id])}}" method="GET">
                        @csrf
                        <input type="text" name="user_id" value="{{ $receipt->user_id }}" hidden>
                        <input type="text" name="receipt_id" value="{{ $receipt->id }}" hidden>
                        <button>View</button>
                    </form>
                </td>
                    
                <td style="border: 1px solid black;">
                    <form action="{{ route('admin.cancel.receipt', [$receipt->id])}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="text" name="user_id" value="{{ $receipt->user_id }}" hidden>
                        <input type="text" name="email" value="{{ $email }}" hidden>
                        <input type="text" name="receipt_id" value="{{ $receipt->id }}" hidden>
                        <button>Cancel</button>
                    </form>
                </td>
                <td style="border: 1px solid black;">
                    <form action="{{ route('admin.confirm.receipt', [$receipt->id])}}" method="POST">
                        @csrf
                        <input type="text" name="user_id" value="{{ $receipt->user_id }}" hidden>
                        <input type="text" name="email" value="{{ $email }}" hidden>
                        <input type="text" name="receipt_id" value="{{ $receipt->id }}" hidden>
                        <input type="text" name="new_wallet_balance" placeholder="New balance">
                        <button>Confirm</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    @else
        <p>Receipts table empty</p>    
    @endif

<br>
</body>
</html>