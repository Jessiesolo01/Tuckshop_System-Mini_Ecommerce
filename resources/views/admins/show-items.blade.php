<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Items</title>
</head>
<body>
    <div>
        @foreach($items as $item)
            <img src="/storage/{{ $item->image }}" alt="" class="w-70">
            <p>{{ $item->item_name }}</p>
            <p>{{ $item->price }}</p>
            @if (count($item->no_of_items_in_stock) === 0)
                <p>This item is unavailable at the moment</p>
            @elseif (count($item->no_of_items_in_stock) === 1)
                <p>{{ $item->no_of_items_in_stock }} item in stock</p>
            @else
                <p>{{ $item->no_of_items_in_stock }} items in stock</p>
            @endif
        @endforeach
    </div> 
</body>
</html>