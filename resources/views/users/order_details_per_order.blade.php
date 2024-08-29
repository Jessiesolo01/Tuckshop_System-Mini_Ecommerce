<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Details</title>
</head>
<body>
    <h1>
        Order Successful, order details in the pdf.
    </h1>

    <form action= "{{ url('/generate-invoice/'.$order_id)}}" method="GET">
        @csrf
        <input type="text" name="order_id" value="{{ $order_id }}" hidden>
        <button style="height:50px; width:200px; background-color:green">Download Invoice</button>
    </form>
    <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a>
    <div>
        @if ($order_items_no != 0)
            <h2>Order Details for Order {{ $order_id }}</h2><br>
            {{-- <h3>Date/Time: {{$date_time}}</h3><br> --}}
            <p>User ID: {{ $user_id}}</p><br>
            {{-- <b>Order ID: {{ $order_id}}</b><br> --}}
        
            <table style="border: 1px solid black;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black;">Order ID</th>
                        <th style="border: 1px solid black;">Item ID</th>
                        <th style="border: 1px solid black;">Item Name</th>
                        <th style="border: 1px solid black;">Item Image</th>
                        <th style="border: 1px solid black;">Item Price</th>
                        <th style="border: 1px solid black;">Item Quantity</th>
                        <th style="border: 1px solid black;">Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $orderItem)
                    <tr>
                        <b><td style="border: 1px solid black;">{{ $orderItem->order_id}}</td></b>
                        <td style="border: 1px solid black;">{{ $orderItem->item_id}}</td>
                        <td style="border: 1px solid black;">{{ $orderItem->item_name}}</td>
                        <td style="border: 1px solid black;"><img src="/storage/{{ $orderItem->image }}" style="height:100px" alt="Picture of the item" class="w-50"></td>
                        <td style="border: 1px solid black;">{{ $orderItem->price }}</td>
                        <td style="border: 1px solid black;">{{ $orderItem->quantity }}</td>
                        <td style="border: 1px solid black;">{{ $orderItem->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- @foreach ($orderItems as $orderItem)
                <p>Item ID: {{ $orderItem->item_id}}</p>
        
                <p>Item Name: {{ $orderItem->item_name}}</p>
                <img src="/storage/{{ $orderItem->image }}" style="height:100px" alt="Picture of the item" class="w-50">
                <p style="margin-right: 20px">Item Price: {{ $orderItem->price }}</p>
                <input type="number" name="quantity" value="{{$orderItem->quantity}}" disabled>
            @endforeach --}}
            <b><p>Number of Items Ordered: {{$orders->no_of_all_items_ordered}}</p></b>
            <b><p>Total Quantity of Items: {{$orders->total_qty_of_all_items_ordered}}</p></b>
            @foreach ($orderItems as $orderItem)
                <p>Cost for {{ $orderItem->item_name}}: {{$orderItem->quantity}} x {{ $orderItem->price }} = 
                    &#8358;{{ $orderItem->quantity * $orderItem->price }}
                </p>    
            @endforeach
            <b><p>Total amount in naira = &#8358;{{ $orders->total_amt_of_all_order_items_in_naira }}</p></b>
    
        @else
            <p>No existing Order</p>
        @endif
    
        
    </div>
</body>
</html>