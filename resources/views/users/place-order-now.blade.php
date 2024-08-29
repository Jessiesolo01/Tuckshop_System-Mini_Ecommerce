<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Place Order Now</title>
</head>
<body>
    <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a><br><br>
    <a href="{{ url('/cart/'.$id) }}">Return to cart</a>
    <div style="border:1px solid black; width:500px; display:flex; padding-top:10px ">

        @if ($wallet_balance >= $total_amount_in_naira)
        <form action="{{ route('place.order.post')}}" method="POST">
            @csrf
            <h1>Wallet Balance: {{ $wallet_balance }}</h1>
            @foreach ($orderItems as $orderItem)
            <input type="text" name="id" value="{{ $id }}" hidden>
                <input type="text" name="cart_id" value="{{ $orderItem->id }}" hidden>
                <input type="text" name="item_id" value="{{ $orderItem->item_id }}" hidden>
                <p>{{ $orderItem->item_name}}</p>
                <img src="/storage/{{ $orderItem->image }}" alt="Picture of the item" class="w-50">
                <p style="margin-right: 20px">{{ $orderItem->price }}</p>
                <input type="number" name="quantity" value="{{$orderItem->quantity}}" disabled>
            @endforeach
            <b><p>Number of Items Ordered: {{$no_of_items_ordered}}</p></b>
            <b><p>Total Quantity of Items: {{$total_quantity_of_items}}</p></b>
            @foreach ($orderItems as $orderItems)
                <p>Cost for {{ $orderItems->item_name}}: {{$orderItems->quantity}} x {{ $orderItems->price }} = 
                    &#8358;{{ $orderItems->quantity * $orderItems->price }}
                </p>    
            @endforeach
            <b><p>Total amount in naira = &#8358;{{ $total_amount_in_naira }}</p></b>
            <button style="background-color: greenyellow">Checkout</button>  
        </form>
        @else
        <form action="{{ route('place.order.post')}}" method="POST">
            @csrf
            <h2>Insufficient wallet balance, please update your balance to proceed with order checkout</h2>
            <h3>Make a Transfer to Account no: 0767082875</h3> 
            <h3>Bank Name: Access bank</h3>
            <h3>Account Name: Jessica Onini Solomon</h3>
            <h3>and upload your reciept for confirmation and update</h3>
            <h1>Wallet Balance: {{ $wallet_balance }}</h1>
            @foreach ($orderItems as $orderItem)
            <input type="text" name="id" value="{{ $id }}" hidden>
                <input type="text" name="cart_id" value="{{ $orderItem->id }}" hidden>
                <input type="text" name="item_id" value="{{ $orderItem->item_id }}" hidden>
                <p>{{ $orderItem->item_name}}</p>
                <img src="/storage/{{ $orderItem->image }}" alt="Picture of the item" class="w-50">
                <p style="margin-right: 20px">{{ $orderItem->price }}</p>
                <input type="number" name="quantity" value="{{$orderItem->quantity}}" disabled>
            @endforeach
            <b><p>Number of Items Ordered: {{$no_of_items_ordered}}</p></b>
            <b><p>Total Quantity of Items: {{$total_quantity_of_items}}</p></b>
            @foreach ($orderItems as $orderItems)
                <p>Cost for {{ $orderItems->item_name}}: {{$orderItems->quantity}} x {{ $orderItems->price }} = 
                    &#8358;{{ $orderItems->quantity * $orderItems->price }}
                </p>    
            @endforeach
            <b><p>Total amount in naira = &#8358;{{ $total_amount_in_naira }}</p></b>
            <button style="background-color: greenyellow" disabled>Checkout</button>
        </form>
        @endif
    </div>
</body>
</html>