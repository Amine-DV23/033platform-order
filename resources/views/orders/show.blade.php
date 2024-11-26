<head>
    <link rel="stylesheet" href="{{ asset('css/style5.css') }}">
</head>

<body>
    <div class="bg-secondary text-center rounded p-4">
        <h2>Order Details</h2>

        <div class="row">
            <div class="col-12">
                <p><strong>Order Date:</strong> {{ $order->date }}</p>
                <p><strong>Order ID:</strong> {{ $order->id }}</p>
                <p><strong>Client Name:</strong> {{ $order->client->name }}</p>
                <p><strong>Phone:</strong> {{ $order->client->phone }}</p>
                <p><strong>Address:</strong> {{ $order->client->address }}</p>
            </div>
        </div>

        <h3>Products</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price per Unit</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->pivot->price }}</td>
                        <td>{{ $product->pivot->total_price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-price">
            <p><strong class="s">Total Order Price: </strong><span style="color: #60ff04"> $
                    {{ $order->total }}</span>
            </p>
        </div>

        <a href="{{ route('orders.index') }}" class="btn mt-4">Back to Orders</a>
    </div>
</body>
