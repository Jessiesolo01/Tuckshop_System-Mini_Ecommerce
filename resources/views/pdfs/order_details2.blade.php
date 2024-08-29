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
        <h2>Order Details</h2><br>
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
                    <td style="border: 1px solid black;">{{ $orderItem->order_id}}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->item_id}}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->item_name}}</td>
                    <td style="border: 1px solid black;"><img src="/storage/{{ $orderItem->image }}" style="height:100px" alt="Picture of the item" class="w-50"></td>
                    <td style="border: 1px solid black;">{{ $orderItem->price }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->quantity }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table><br><br>
        <b><p>Number of Items Ordered: {{$orders->no_of_all_items_ordered}}</p></b>
        <b><p>Total Quantity of Items: {{$orders->total_qty_of_all_items_ordered}}</p></b>
        @foreach ($orderItems as $orderItem)
            <p>Cost for {{ $orderItem->item_name}}: {{$orderItem->quantity}} x {{ $orderItem->price }} = 
                &#8358;{{ $orderItem->quantity * $orderItem->price }}
            </p>    
        @endforeach
        <b><p>Total amount in naira = &#8358;{{ $orders->total_amt_of_all_order_items_in_naira }}</p></b>
    </div>
</body>
</html>