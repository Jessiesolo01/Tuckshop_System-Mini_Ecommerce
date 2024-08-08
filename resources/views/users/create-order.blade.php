<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="../resources/js/app.js"></script>
    <title>Place Order</title>
</head>
<body>
    {{-- <form action="{{ route('create.order.post') }}" method="POST"> --}}
    <form action="{{ url('/create-order/'.$id) }}"  {{--onsubmit="getQuantity()"--}} method="POST">
        @csrf
        @foreach($items as $item)
        <div style="border:1px solid black; width:500px; display:flex; padding-top:10px ">
            <input type="text" name="id" value="{{ $id }}" hidden>
            <input type="text" name="item_id" value="{{ $item->id }}" hidden>
                @if ($item->no_of_items_in_stock === 0)
                    {{-- <input type="checkbox" name="{{'qty_'.$item->id}}" value="" disabled> --}}
                    {{-- <input type="checkbox" name="options[].{{$item->id}}" value="1" disabled> --}}
                    {{-- <input type="checkbox" name="options[].{{$item->id}}" value="{{$item->id}}" disabled> --}}

                    {{-- <input type="checkbox" name="options[]" value="1" disabled> --}}
                    <input type="checkbox" name="options[]" value="{{ $item->id }}" disabled>
                    {{-- <input type="text" name="options[]" id="qty" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity" disabled> --}}
                    {{-- <input type="text" name="options[]" placeholder="Quantity" disabled> --}}


                    {{-- <label for="qty" >{{ $item->item_name }}</label> --}}
                @else
                    {{-- <input type="checkbox" name="{{'qty_'.$item->id}}" value=""> --}}
                    {{-- <input type="checkbox" name="options[].{{$item->id}}" value="1"> --}}
                    {{-- <input type="checkbox" name="options[].{{$item->id}}" value="{{$item->id}}"> --}}
                    {{-- <input type="checkbox" name="options[]" value="1"> --}}
                    <input type="checkbox" name="options[]" value="{{ $item->id }}">
                    {{-- <input type="text" name="options[]" id="qty" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity"> --}}
                    {{-- <input type="text" name="options[]" placeholder="Quantity"> --}}

                    {{-- <label for="qty" >{{ $item->item_name }}</label> --}}
                    {{-- <input type="checkbox" name="options[]" value="{{ $item->quantity }}"> --}}

                    {{-- <input type="checkbox" name="options[]" @if($item->options) checked @endif item = {{ old('options[]',$item->options)}}"> --}}
                     
                @endif
                <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-50">
                <p style="margin-right: 20px">{{ $item->price }}</p>
                {{-- <input type="number" name="quantity" id="qty" value="min.max" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity"> --}}
                {{-- <input type="number" name="quantity" id="qty" placeholder="Quantity"> --}}
                <input type="number" name="quantity" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity">
                {{-- <input type="number" name="options[]" min="1" max="{{ $item->no_of_items_in_stock }}" placeholder="Quantity"> --}}
                @if ($item->no_of_items_in_stock === 0)
                    <p>Out of stock </p>
                @elseif ($item->no_of_items_in_stock === 1)
                    <p>{{ $item->no_of_items_in_stock }} item in stock</p>
                @else
                    <p>{{ $item->no_of_items_in_stock }} items in stock</p>
                @endif
            <br>
            <br>
        </div>
        @endforeach
        <button type="submit">Place Order</button>
    </form>
    {{-- @section('scripts')
    <script type="text/javascript">
        // function getQuantity() {
            // const quantity = document.querySelector('input[name="quantity"]');
            // const options = document.querySelector('input[name="options[]"]');

            // let quan_value = quantity.value;
            // let options.value = quan_value;
            // let op_value = quan_value 


        // }
        function getQuantity(){
            alert("Hi";)
            // var quantity = document.getElementById('qty');
            // var quan_value = quantity.value;
            // const options = document.querySelector('input[name="options[]"]');
            // document.getElementsByName('options[]').value = quan_value;
        }
            
    </script>
    @endsection --}}
</body>
</html>