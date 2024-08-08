<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Place an order</title>
</head>
<body>
    @if (session('success'))
    <div class="alert alert-danger">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
    @foreach($items as $item)
        @if ($item->no_of_items_in_stock === 0)
        <div style="border:1px solid black; width:500px; display:flex; padding-top:10px ">

        <form action="{{ url('/cart/'.$id) }}" method="POST">
            @csrf
            <input type="text" name="id" value="{{ $id }}" hidden>
            <input type="text" name="item_id" value="{{ $item->id }}" hidden>
            <p>{{ $item->item_name }}</p>
            <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-50">
            <p style="margin-right: 20px">{{ $item->price }}</p>
            <input type="number" name="quantity" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity">
            @if ($item->no_of_items_in_stock === 0)
                <p>Out of stock </p>
            @elseif ($item->no_of_items_in_stock === 1)
                <p>{{ $item->no_of_items_in_stock }} item in stock</p>
            @else
                <p>{{ $item->no_of_items_in_stock }} items in stock</p>
            @endif
            <button disabled="disabled" style="background-color: blueviolet">Add To Cart</button>
        </form>
        </div>
        @else
        <div style="border:1px solid black; width:500px; display:flex; padding-top:10px ">
        <form action="{{ url('/cart/'.$id) }}" method="POST">
            @csrf
            <input type="text" name="id" value="{{ $id }}" hidden>
            <input type="text" name="item_id" value="{{ $item->id }}" hidden>
            <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-50">
            <p style="margin-right: 20px">{{ $item->price }}</p>
            <input type="number" name="quantity" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity">
            @if ($item->no_of_items_in_stock === 0)
                <p>Out of stock </p>
            @elseif ($item->no_of_items_in_stock === 1)
                <p>{{ $item->no_of_items_in_stock }} item in stock</p>
            @else
                <p>{{ $item->no_of_items_in_stock }} items in stock</p>
            @endif
            <button style="background-color:blueviolet">Add To Cart</button>     
        </form>
        </div>
        @endif
        <br>
        <br>
    @endforeach
</body>
</html>