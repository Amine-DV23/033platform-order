@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="home" class="section">
            <h1>Welcome to Order Management System</h1>
            <p>Use the navigation menu to manage orders, clients, and products.</p>
        </div>
    </div>
    <div class="cards">

        <div class="card" onclick="location.href='Clients'">
            <i class="icon">&#128100;</i>
            <h5>Add New Client</h5>
            <p>registering all the details of a new client, including name, address, and
                contact information, with the ability to manage their data easily in the future.</p>
        </div>

        <div class="card" onclick="location.href='products'">
            <i class="icon">&#128178;</i>
            <h5>Add New Product</h5>
            <p>add new products to the system, recording all relevant details such as name,
                description, price, and available quantities.</p>
        </div>

        <div class="card" onclick="location.href='orders'">
            <i class="icon">&#128179;</i>
            <h5>Create New Order</h5>
            <p>Create a new order effortlessly, with the ability to log all its details, including order type, quantity,
                associated client, and delivery date.</p>
        </div>

        <div class="card" onclick="location.href='Clients'">
            <i class="icon">&#128101;</i>
            <h5>View Clients</h5>
            <p>View a comprehensive list of all clients registered in the system, along with their personal details and
                transaction history.</p>
        </div>

        <div class="card" onclick="location.href='products'">
            <i class="icon">&#128200;</i>
            <h5>View Product</h5>
            <p>An advanced page to display all product information, including price tracking, available quantities, and
                specifications, with detailed analytics.</p>
        </div>

        <div class="card" onclick="location.href='orders'">
            <i class="icon">&#128195;</i>
            <h5>View Orders</h5>
            <p>A dedicated section to view all registered orders, with precise details for each order, such as its status,
                associated client, and delivery timeline.</p>
        </div>


    </div>
@endsection
