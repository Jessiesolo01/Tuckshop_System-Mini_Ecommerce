<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form action="{{ url('/admin/update-item/'.$item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="text" name="item_name" placeholder="Name of item" value="{{ $item->item_name }}">
        {{-- <img src="/storage/{{ $item->image }}" alt="Picture of the item" class="w-70"> --}}
        <input type="file" name="image" placeholder="Choose Image">
        <input type="text" name="price" placeholder="Price of the item" value="{{ $item->price }}">
        <input type="text" name="no_of_items_in_stock" placeholder="Number in stock" value="{{ $item->no_of_items_in_stock }}">
        <input type="text" name="updated_by" value="{{ $username }}" hidden>
        {{-- <input type="datetime-local" name="updated_at" value="{{ $updated_at }}" hidden>
        <label for="html">Time Updated</label><br> --}}
        {{-- <input type="text" name="created_at">
        <input type="text" name="updated_at"> --}}
        <button>Update Item</button>
    </form>
</body>
</html>