<!-- resources/views/update_status.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order Status</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Update Order Status</h1>
        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="ordered">Ordered</option>
                <option value="paid">Paid</option>
                <option value="delivering">Delivering</option>
                <option value="delivered">Delivered</option>
            </select>
            <button type="submit">Update Status</button>
        </form>
    </div>
</body>
</html>