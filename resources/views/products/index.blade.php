@extends('layouts.app')

@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">

            <h1>Add Products</h1>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <label for="name">Name-Product:</label>
                <input type="text" name="name" value="" required>
                <br>

                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" value="" required>
                <br>
                <br>
                <label style="width: 100%" for="note">Note:</label>

                <textarea style="width: 100%;height: 50px;" name="note"></textarea>
                <br>

                <br> Add-Image:<br>
                <input style="width: 20%;height: 30px;padding: 10px 10px;font-size:10px;" type="file" id="productImage"
                    name="image" accept="image/*">


                <button type="submit" id="submitButton">Add-Product</button>
            </form>
        </div>
    </div>
    <!-- Recent Sales End -->



    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">



            <h1>List Products</h1>


            <table border="1">
                <thead>
                    <tr>
                        <th>Name Product</th>
                        <th>Price Product</th>
                        <th>Image Product</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="50">
                            </td>
                            <td>{{ $product->note }}</td>
                            <td>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button style=";background-color: #ff0000;" type="submit">Delete</button>
                                </form>

                                <button style=";background-color: #4CAF50;"
                                    onclick='fillForm({ id: "{{ $product->id }}", name: "{{ $product->name }}", price: "{{ $product->price }}", note: "{{ $product->note }}" })'>Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Recent Sales End -->




    <script>
        function fillForm(product) {
            document.querySelector('input[name="name"]').value = product.name;
            document.querySelector('input[name="price"]').value = product.price;
            document.querySelector('textarea[name="note"]').value = product.note;


            document.getElementById('submitButton').innerText = 'Update Product';


            document.getElementById('productForm').action = `/products/${product.id}`;
            document.querySelector('input[name="_method"]').value = 'PATCH';
        }
    </script>
@endsection
