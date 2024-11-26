@extends('layouts.app')

@section('content')
    <!-- Sale & Revenue Start -->


    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-line fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Today Order</p>
                        <p style="color: #ff7b00;;font-size:20px"> Order : <span style="color: #fcfcfc" id="totalOrdersCount">
                                {{ $totalOrdersCount }} </span></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-chart-bar fa-3x text-primary"></i>
                    <div class="ms-3">
                        <p class="mb-2">Total Sale</p>
                        <p><span style="color: #2e8d46;font-size:20px"> $ </span><span style="color: #fcfcfc"
                                id="totalOrdersAmount">{{ number_format($totalOrdersAmount, 2) }}</span></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Sale & Revenue End -->


    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">




            <h2>Add Order</h2>

            <div class="row">





                <select id="clientSelect">
                    <option value="">Select Client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" data-phone="{{ $client->phone }}"
                            data-address="{{ $client->address }}">
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>

                <input type="number" placeholder="Phone" id="phone" readonly />
                <input type="text" placeholder="Address" id="address" readonly />




                <input type="date" id="currentDate" value="" />
            </div>


            <div id="productRows">
                <div class="row">







                    <select id="product0" class="productSelect" onchange="updateProductDetails(0)">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>


                    <input type="text" placeholder="Product ID" id="productId0" readonly style="display: none;" />


                    <input type="text" placeholder="Product Name" id="productName0" readonly style="display: none;" />


                    <input type="number" placeholder="Price" id="price0" readonly />




                    <input type="number" placeholder="Quantity" id="quantity0" step="0.01"
                        oninput="calculateTotalPrice(0)" />
                    <input type="number" placeholder="Total Price" id="totalPrice0" readonly />
                </div>
            </div>

            <div class="add-button" onclick="addRow()"><span class="plus">➕</span></div>

            <div class="save-button">
                <button id="saveButton">Save-Order</button>
            </div>


            <div class="total-price-order">
                <label style="margin-right: 20px;margin-bottom: -20px;text-align: right;">Total Price Order</label>
                <br>
                <input type="text" id="orderTotalPrice" readonly />
            </div>








        </div>
    </div>
    <!-- Recent Sales End -->



    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">


            <div class="table-title">Order Summary</div>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Order Total</th>
                        <th> Action</th>
                    </tr>
                </thead>
                <tbody id="orderTableBody">
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->date }}</td>
                            <td>{{ $order->client->name }}</td>
                            <td>{{ $order->total }}</td>
                            <td>
                                <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button style="background-color: #ff0000;" type="submit">Delete</button>
                                </form>
                                <button onclick="window.location.href='{{ route('orders.show', $order->id) }}'"
                                    style="background-color: #4CAF50; color: white; padding: 5px 10px; border-radius: 5px; border: none; cursor: pointer;">
                                    Show
                                </button>

                            </td>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
    <!-- Recent Sales End -->






    <script>
        function toggleMenu() {
            const headerContainer = document.querySelector('.header-container');
            headerContainer.classList.toggle('menu-active');
        }


        const orders = @json($orders);
        const totalOrdersCount = {{ $totalOrdersCount }};
        const totalOrdersAmount = {{ $totalOrdersAmount }};


        function updateSummary(orders) {
            const totalOrdersCount = orders.length;
            const totalOrdersAmount = orders.reduce((sum, order) => sum + parseFloat(order.total || 0), 0);

            document.getElementById('totalOrdersCount').textContent = totalOrdersCount;
            document.getElementById('totalOrdersAmount').textContent = totalOrdersAmount.toFixed(2);
        }


        document.addEventListener('DOMContentLoaded', function() {
            updateSummary(orders);
        });


        document.getElementById("currentDate").valueAsDate = new Date();


        function updatePrice(index) {
            const productSelect = document.getElementById(`product${index}`);
            const priceField = document.getElementById(`price${index}`);
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const price = selectedOption.getAttribute("data-price");
            priceField.value = price || 0;
            calculateTotalPrice(index);
        }


        function calculateTotalPrice(index) {
            const price = parseFloat(document.getElementById(`price${index}`).value) || 0;
            const quantity = parseFloat(document.getElementById(`quantity${index}`).value) || 0;
            const totalPrice = price * quantity;
            document.getElementById(`totalPrice${index}`).value = totalPrice.toFixed(2);
            updateOrderTotal();
        }


        function updateOrderTotal() {
            let totalOrderPrice = 0;
            const totalPrices = document.querySelectorAll("[id^='totalPrice']");
            totalPrices.forEach(totalPriceInput => {
                const totalPrice = parseFloat(totalPriceInput.value) || 0;
                totalOrderPrice += totalPrice;
            });

            document.getElementById("orderTotalPrice").value = totalOrderPrice.toFixed(2);
        }

        function updateProductDetails(index) {
            const productSelect = document.getElementById(`product${index}`);
            const selectedOption = productSelect.options[productSelect.selectedIndex];


            const productId = selectedOption.value;
            const productName = selectedOption.getAttribute('data-name');
            const productPrice = selectedOption.getAttribute('data-price');


            document.getElementById(`productId${index}`).value = productId;
            document.getElementById(`productName${index}`).value = productName;
            document.getElementById(`price${index}`).value = productPrice;


            calculateTotalPrice(index);
        }


        function addRow() {
            const rowIndex = document.querySelectorAll(".row").length;
            const newRow = document.createElement("div");
            newRow.classList.add("row");

            newRow.innerHTML = `
        <select id="product${rowIndex}" class="productSelect" onchange="updateProductDetails(${rowIndex})">
            <option value="">Select Product</option>
            @foreach ($products as $product)
                <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
        <input style="display: none;" type="text"  type="text" placeholder="Product ID" id="productId${rowIndex}" readonly />
        <input style="display: none;" placeholder="Product Name" id="productName${rowIndex}" readonly />
        <input type="number" placeholder="Price" id="price${rowIndex}" readonly />
        <input type="number" placeholder="Quantity" id="quantity${rowIndex}" step="0.01" oninput="calculateTotalPrice(${rowIndex})" />
        <input type="number" placeholder="Total Price" id="totalPrice${rowIndex}" readonly />
    `;


            document.getElementById("productRows").appendChild(newRow);
        }


        function showMessage(message, type = 'success') {
            const messageDiv = type === 'success' ? document.getElementById('successMessage') : document.getElementById(
                'successMessage');
            messageDiv.textContent = message;
            messageDiv.style.display = 'block';


            setTimeout(() => {
                messageDiv.style.display = 'none';


                if (type === 'success') {
                    location.reload();
                }
            }, 3000);
        }
        document.getElementById('clientSelect').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var phoneNumber = selectedOption.getAttribute('data-phone');
            var address = selectedOption.getAttribute('data-address');

            document.getElementById('phone').value = phoneNumber;
            document.getElementById('address').value = address;
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            const client_id = document.getElementById('clientSelect').value;
            const date = document.getElementById('currentDate').value;
            const total = parseFloat(document.getElementById('orderTotalPrice').value);

            const productRows = document.querySelectorAll("#productRows .row");
            const products = [];


            const order_id = Date.now();

            productRows.forEach((row, index) => {

                const productId = row.querySelector(`[id^="productId"]`)?.value;
                const productName = row.querySelector(`[id^="productName"]`)?.value;
                const price = parseFloat(row.querySelector(`[id^="price"]`)?.value);
                const quantity = parseFloat(row.querySelector(`[id^="quantity"]`)?.value);
                const totalPrice = parseFloat(row.querySelector(`[id^="totalPrice"]`)?.value);


                if (productId && productName && !isNaN(price) && !isNaN(quantity) && !isNaN(totalPrice)) {
                    products.push({
                        order_id: order_id,
                        product_id: productId,
                        product_name: productName,
                        price: price,
                        quantity: quantity,
                        total_price: totalPrice
                    });
                }
            });


            if (!client_id || !date || isNaN(total) || products.length === 0) {
                showMessage('يرجى ملء جميع الحقول بشكل صحيح', 'error');
                return;
            }


            fetch('{{ route('save.order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        client_id,
                        date,
                        total,
                        products
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showMessage('تم حفظ الطلب بنجاح');
                        document.getElementById('orderTableBody').innerHTML = data.orderRows;
                        resetForm();
                    } else {
                        showMessage(data.message || 'تم حفظ الطلب بنجاح', 'error');
                    }
                })
                .catch(error => {
                    showMessage('فشل الاتصال بالخادم', 'error');
                    console.error(error);
                });
        });


        function filterProducts() {
            let input = document.getElementById('searchInput').value.toLowerCase();
            let tableRows = document.querySelectorAll('#orderTableBody tr');

            tableRows.forEach(row => {
                let clientName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                if (clientName.startsWith(input)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
        document.getElementById('searchInput').addEventListener('input', function() {
            let char = this.value;

            fetch(`/filter-orders?char=${char}`)
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById('orderTableBody');
                    tableBody.innerHTML = '';

                    data.forEach(order => {
                        tableBody.innerHTML += `
                    <tr>
                        <td>${order.date}</td>
                        <td>${order.client.name}</td>
                        <td>${order.total}</td>
                    </tr>
                `;
                    });
                });
        });
    </script>
@endsection
