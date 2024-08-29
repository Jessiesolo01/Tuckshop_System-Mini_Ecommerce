<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title>
</head>
<body>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
    @endif
    <br><br>
    <a href="{{ url('/admin/dashboard/'.$admin_id) }}">Return to dashboard</a><br><br>

    @if ($no_of_orders != 0)
    <form action="{{ url('/search-order') }}" method="GET">
        @csrf
        <input type="text" name="query" placeholder="Enter User ID, Order ID or Table ID">
        <button type="submit">Search</button>
    </form><br>

    <table style="border: 1px solid black;">
        <thead>
            <tr>
                <th style="border: 1px solid black;">Table ID</th>
                <th style="border: 1px solid black;">Order ID</th>
                <th style="border: 1px solid black;">User ID</th>
                <th style="border: 1px solid black;">Owner</th>
                <th style="border: 1px solid black;">Item ID</th>
                <th style="border: 1px solid black;">Item Name</th>
                <th style="border: 1px solid black;">Item Image</th>
                <th style="border: 1px solid black;">Item Price</th>
                <th style="border: 1px solid black;">Item Quantity</th>
                <th style="border: 1px solid black;">Order Date</th>
                <th style="border: 1px solid black;">No of all Items Ordered</th>
                <th style="border: 1px solid black;">Total qty of all Items ordered</th>
                <th style="border: 1px solid black;">Total amt of all Items Ordered In Naira</th>
            
                <th style="border: 1px solid black;">Updated At</th>
            </tr>
        </thead>
        <tbody>
            @if($orders->isNotEmpty())
                @foreach ($orders as $order)
                <tr>
                    <td style="border: 1px solid black;">{{ $order->id}}</td>
                    <b><td style="border: 1px solid black;">{{ $order->order_id}}</td></b>
                    <td style="border: 1px solid black;">{{ $order->user_id}}</td>
                    <td style="border: 1px solid black;">{{ $order->order_owner}}</td>

                    <td style="border: 1px solid black;">{{ $order->item_id}}</td>
                    <td style="border: 1px solid black;">{{ $order->item_name}}</td>
                    <td style="border: 1px solid black;"><img src="/storage/{{ $order->image }}" style="height:100px" alt="Picture of the item" class="w-50"></td>
                    <td style="border: 1px solid black;">{{ $order->price }}</td>
                    <td style="border: 1px solid black;">{{ $order->quantity }}</td>
                    <td style="border: 1px solid black;">{{ $order->created_at }}</td>
                    <td style="border: 1px solid black;">{{ $order->no_of_all_items_ordered }}</td>
                    <td style="border: 1px solid black;">{{ $order->total_qty_of_all_items_ordered }}</td>
                    <td style="border: 1px solid black;">{{ $order->total_amt_of_all_order_items_in_naira }}</td>
                    <td style="border: 1px solid black;">{{ $order->updated_at }}</td>
                </tr>
                @endforeach
            {{-- @else
                @foreach ($orderItems as $orderItem)
                <tr>
                    <td style="border: 1px solid black;">{{ $orderItem->id}}</td>
                    <b><td style="border: 1px solid black;">{{ $orderItem->order_id}}</td></b>
                    <td style="border: 1px solid black;">{{ $orderItem->user_id}}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->order_owner}}</td>

                    <td style="border: 1px solid black;">{{ $orderItem->item_id}}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->item_name}}</td>
                    <td style="border: 1px solid black;"><img src="/storage/{{ $orderItem->image }}" style="height:100px" alt="Picture of the item" class="w-50"></td>
                    <td style="border: 1px solid black;">{{ $orderItem->price }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->quantity }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->created_at }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->no_of_all_items_ordered }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->total_qty_of_all_items_ordered }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->total_amt_of_all_order_items_in_naira }}</td>
                    <td style="border: 1px solid black;">{{ $orderItem->updated_at }}</td>
                </tr>
                @endforeach--}}
            @endif 
            
        </tbody>
    </table>
    @else
        <p>Receipts table empty</p>    
    @endif

<br>
</body>
</html>