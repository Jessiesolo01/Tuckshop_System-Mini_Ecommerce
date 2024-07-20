<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Items</title>
</head>
<body>
    <h2>List of Items</h2>
    <div>
        @foreach($items as $item)
        <div style="border:1px solid black; width:200px">
            <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-70">
            {{-- <img src="{{ asset('storage/'.$item->image)  }}" alt="Picture of the item" class="w-70"> --}}
            <p>{{ $item->id }}</p>
            <p>{{ $item->item_name }}</p>
            <p>{{ $item->price }}</p>
            @if ($item->no_of_items_in_stock === 0)
                <p>This item is unavailable at the moment</p>
            @elseif ($item->no_of_items_in_stock === 1)
                <p>{{ $item->no_of_items_in_stock }} item in stock</p>
            @else
                <p>{{ $item->no_of_items_in_stock }} items in stock</p>
            @endif
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
    </div> 
</body>
</html>