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
    
    @if(count($cartItem) == 0)
        <h1>There is no item in cart</h1><br>
        <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a><br>
    @else
    <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a><br><br>
        @foreach($cartItem as $cartItem)
            <div style="border:1px solid black; width:500px; display:flex; padding-top:10px ">
            <form action="{{ url('/cart/'.$id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="text" name="id" value="{{ $id }}" hidden>
                <input type="text" name="cart_id" value="{{ $cartItem->id }}" hidden>
                <input type="text" name="item_id" value="{{ $cartItem->item_id }}" hidden>
                <p>{{ $cartItem->item_name}}</p>
                <img src="/storage/{{ $cartItem->image }}" alt="Picture of the item" class="w-50">
                <p style="margin-right: 20px">{{ $cartItem->price }}</p>
                <input type="number" name="quantity" value="{{$cartItem->quantity}}" disabled>
                {{-- @if ($item->no_of_items_in_stock === 0)
                    <p>Out of stock </p>
                @elseif ($item->no_of_items_in_stock === 1)
                    <p>{{ $item->no_of_items_in_stock }} item in stock</p>
                @else
                    <p>{{ $item->no_of_items_in_stock }} items in stock</p>
                @endif --}}
                <button style="background-color:blueviolet">Remove Item</button>     
            </form><br>
            <form action="{{ url('/cart/'.$id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="id" value="{{ $id }}" hidden>
                <input type="text" name="cart_id" value="{{ $cartItem->id }}" hidden>
                <input type="text" name="item_id" value="{{ $cartItem->item_id }}" hidden>
                @foreach ($item as $item)
                    <input style="background: red" type="number" name="new_quantity" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="New Quantity"><br>
                @endforeach
                <input style="width: 100px" type="number" name="new_quantity" min="1" max="70" placeholder="New Quantity"><br>

                <button style="background: blue">Save</button>
            </form><br>
            </div>
            <br>
            <br>
        @endforeach
        <form action="{{ route('place.order') }}" method="GET">
            @csrf
            <button style="background-color:green">Proceed to Order</button>
        </form>
    @endif
</body>
</html>