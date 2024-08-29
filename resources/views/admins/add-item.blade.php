<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Item</title>
</head>
<body>
    <a href="{{ url('/admin/dashboard/'.$id) }}">Return to dashboard</a><br><br>

    <h1>Add Item</h1>
    <form action="{{ route('admin.addItem.post') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="item_name" placeholder="Name of item">
        <input type="file" name="image">
        <input type="text" name="price" placeholder="Price of the item">
        <input type="text" name="no_of_items_in_stock" placeholder="Number in stock">
        <input type="text" name="created_by" value="{{ $username }}" hidden>
        <input type="text" name="updated_by" value="{{ $username }}" hidden>
        {{-- <input type="text" name="created_at">
        <input type="text" name="updated_at"> --}}
        <button>Create Item</button>
    </form>
</body>
</html>