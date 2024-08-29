<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Details</title>
</head>
<body>
    
    <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a>
    <div>
        @if ($order_items_no != 0)
        <h1>
            Order Successful, here are the order details.
        </h1><br><br>
            <h2>Order Details</h2><br>
            {{-- <h3>Date/Time: {{$date_time}}</h3><br> --}}
            <p>User ID: {{ $user_id}}</p><br>
            {{-- <b>Order ID: {{ $order_id}}</b><br> --}}
            @foreach ($order_ids as $order_id)
            <form action= "{{ url('/order-details/order/'.$order_id->order_id)}}" method="GET">
                @csrf
                <input type="text" name="order_id" value="{{ $order_id->order_id }}" hidden>
                <button style="height:50px; width:200px; background-color:green">Get details for Order {{$order_id->order_id}}</button>
            </form><br>
            @endforeach
            
    
        @else
            <h2>No existing Order</h2>
        @endif
    
        
    </div>
</body>
</html>