<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Items</title>
</head>
<body>
    <a href="{{ url('/admin/dashboard/'.$admin_id) }}">Return to dashboard</a><br><br>
    <a href="{{ route('admin.showItem') }}">Items</a><br><br>

    @if ($no_of_items != 0)
    <form action="{{ route('admin.search.item') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="Enter Item ID, Item Name, Price, No in stock, Created By or Updated By" style="width: 500px">
        <button>Search</button>
    </form><br>
    <h2>List of Items</h2>


    <table>
        <tr>
            <th style="border: 1px solid black;">Item Image</th>
            <th style="border: 1px solid black;">Item ID</th>
            <th style="border: 1px solid black;">Item Name</th>
            <th style="border: 1px solid black;">Price</th>
            <th style="border: 1px solid black;">No in Stock</th>
            <th style="border: 1px solid black;">Created By</th>
            <th style="border: 1px solid black;">Created At</th>
            <th style="border: 1px solid black;">Updated By</th>
            <th style="border: 1px solid black;">Updated At</th>
        </tr>
        @foreach($items as $item)
        <tr>
            <td style="border: 1px solid black;"><img src="/storage/{{ $item->image }}" style="height:100px" alt="Picture of the item" class="w-50"></td>
            <td style="border: 1px solid black;">{{ $item->id }}</td>
            <td style="border: 1px solid black;">{{ $item->item_name }}</td>
            <td style="border: 1px solid black;">{{ $item->price }}</td>
            @if ($item->no_of_items_in_stock === 0)
                <td>This item is unavailable at the moment</td>
            @else ($item->no_of_items_in_stock === 1)
                <td style="border: 1px solid black;">{{ $item->no_of_items_in_stock }}</td>
            @endif
            <td style="border: 1px solid black;">{{ $item->created_by }}</td>
            <td style="border: 1px solid black;">{{ $item->created_at }}</td>
            <td style="border: 1px solid black;">{{ $item->updated_by }}</td>
            <td style="border: 1px solid black;">{{ $item->updated_at }}</td>
            <td style="border: 1px solid black;"><a href="{{ route('admin.editItem', [$item->id]) }}">Edit</a></td>
            <td style="border: 1px solid black;">
                <form action="{{ route('admin.deleteItem', [$item->id])}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


    {{-- <div>
        @foreach($items as $item)
        <div style="border:1px solid black; width:200px">
            <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-70"> --}}
            {{-- <img src="{{ asset('storage/'.$item->image)  }}" alt="Picture of the item" class="w-70"> --}}
            {{-- <p>{{ $item->id }}</p>
            <p>{{ $item->item_name }}</p>
            <p>{{ $item->price }}</p>
            
            @if ($item->no_of_items_in_stock === 0)
                <p>This item is unavailable at the moment</p>
            @elseif ($item->no_of_items_in_stock === 1)
                <p>{{ $item->no_of_items_in_stock }} item in stock</p>
            @else
                <p>{{ $item->no_of_items_in_stock }} items in stock</p>
            @endif
            <p><b>Created By: </b>{{ $item->created_by }}</p>
            <p><b>Created At: </b>{{ $item->created_at }}</p>
            <p><b>Updated By: </b>{{ $item->updated_by }}</p>
            <p><b>Updated At: </b>{{ $item->updated_at }}</p>
            <a href="{{ route('admin.editItem', [$item->id]) }}">Edit</a>
            <form action="{{ route('admin.deleteItem', [$item->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <button>Delete</button>
            </form>
            <br>
            <br>
        </div>
        @endforeach
        <br>
        <br>
    </div>  --}}
    @else
        <p>Items Table Empty</p>
    @endif
</body>
</html>