@extends('layouts.app')

@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">



            <h1>Add Clients</h1>
            <form id="clientForm" action="{{ route('Clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="form-group">
                    <label for="name">Name Client:</label>
                    <input type="text" name="name" id="name" value="" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" name="address" id="address" value="" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" name="phone" id="phone" value="" required>
                </div>

                <div class="form-group">
                    <label style="width: 100%" for="note">Note:</label>

                    <textarea style="width: 100%;height: 50px;" name="note"></textarea>
                    <br>
                    <button type="submit" id="submitButton">Add Client</button>
                    <br>
            </form>

        </div>
    </div>
    <!-- Recent Sales End -->



    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">




            <h1>List Clients</h1>



            <table border="1">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($Clients as $Client)
                        <tr>
                            <td>{{ $Client->name }}</td>
                            <td>{{ $Client->address }}</td>
                            <td>{{ $Client->phone }}</td>
                            <td>{{ $Client->note }}</td>
                            <td>
                                <form action="{{ route('Clients.destroy', $Client->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button style=";background-color: #ff0000;"type="submit">Delete</button>
                                </form>


                                <button style=";background-color: #4CAF50;"
                                    onclick='fillForm({ id: "{{ $Client->id }}", name: "{{ $Client->name }}", address: "{{ $Client->address }}", phone: "{{ $Client->phone }}", note: "{{ $Client->note }}" })'>Update</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>
    <!-- Recent Sales End -->







    <script>
        function fillForm(Client) {
            document.querySelector('input[name="name"]').value = Client.name;
            document.querySelector('input[name="address"]').value = Client.address;
            document.querySelector('input[name="phone"]').value = Client.phone;
            document.querySelector('textarea[name="note"]').value = Client.note;


            document.getElementById('submitButton').innerText = 'Update Client';


            document.getElementById('clientForm').action = `/Clients/${Client.id}`;
            document.querySelector('input[name="_method"]').value = 'PATCH';
        }
    </script>
@endsection
