@extends('layouts.app')

@section('content')
    <!-- Recent Sales Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">


            <div id="login-form" class="login-form">
                <h1>Login Account</h1>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                </form>
                <button id="show-register" onclick="showRegister()">Register ? </button>
            </div>

            <div id="register-form" class="register-form" style="display: none;">
                <h1>Create an Account</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                        <label for="name">Name:</label>
                        <input id="name" type="text" name="name" required>
                    </div>
                    <div>
                        <label for="email">Email:</label>
                        <input id="email" type="email" name="email" required>
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input id="password" type="password" name="password" required>
                    </div>
                    <div>
                        <label for="password_confirmation">Confirm Password:</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required>
                    </div>
                    <button type="submit">Register</button>
                </form>
                <button id="show-login" onclick="showLogin()">Login ? </button>
            </div>
            <br> <br>

            <script>
                function showRegister() {
                    document.getElementById('login-form').style.display = 'none';
                    document.getElementById('register-form').style.display = 'block';
                }

                function showLogin() {
                    document.getElementById('register-form').style.display = 'none';
                    document.getElementById('login-form').style.display = 'block';
                }
            </script>

        </div>

    </div>
    <!-- Recent Sales End -->
@endsection
