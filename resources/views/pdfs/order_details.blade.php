<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Details</title>
</head>
<body>
    <div>
    <h2>{{$title}}</h2><br>
    <h3>Date/Time: {{$date_time}}</h3><br>
    <p>User ID: {{ $user_id}}</p><br>
    <b>Order ID: {{ $order_id}}</b><br>
    @foreach ($orderItems as $orderItem)
        {{-- <input type="text" name="id" value="{{ $orderItem->user_id }}" hidden>
        <input type="text" name="cart_id" value="{{ $orderItem->id }}" hidden>
        <input type="text" name="item_id" value="{{ $orderItem->item_id }}" hidden> --}}
        <p>Item ID: {{ $orderItem->item_id}}</p>
        <p>Item Name: {{ $orderItem->item_name}}</p>
        <img src="/storage/{{ $orderItem->image }}" alt="Picture of the item" class="w-50">
        <p style="margin-right: 20px">Item Price: {{ $orderItem->price }}</p>
        <p>Item Quantity: {{ $orderItem->quantity}}</p>

    @endforeach
        <b><p>Number of Items Ordered: {{$no_of_items_ordered}}</p></b>
        <b><p>Total Quantity of Items: {{$total_quantity_of_items}}</p></b>
        @foreach ($orderItems as $orderItems)
            <p>Cost for {{ $orderItems->item_name}}: {{$orderItems->quantity}} x {{ $orderItems->price }} = 
                &#8358;{{ $orderItems->quantity * $orderItems->price }}
            </p>    
        @endforeach
        <b><p>Total amount in naira = &#8358;{{ $total_amount_in_naira }}</p></b>
    </div>
</body>
</html>