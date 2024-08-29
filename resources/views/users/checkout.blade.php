<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Checkout</title>
</head>
<body>
    <div>
        <h1>
            Order Successful, order details in the pdf. <a href="{{url('/order-details/'.$id)}}">Proceed to view or download order details</a>
        </h1>
         <a href="{{ url('/dashboard/'.$id) }}">Return to dashboard</a>
    </div>
</body>
</html>