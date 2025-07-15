<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/student-login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    <?php
        if(DB::connection()->getPdo()){
                echo "connection ok";
        }
    ?>
    <div class="login-container">
        <div class="logo">
            <img src="{{ asset('icon/logo.png') }}" class="logo-image" src="media/logo.png">
            <div>
            <p class="login-title">PTBTP eLearning</p>

            </div>
        </div>
        <div class="login">
            <form action="/studentLogin" method="POST">
                @csrf
                <input class="username-form" type="text" name="username" placeholder="Username"> <!-- Ensure 'name="username"' -->
                <br>
                <input class="password-form" type="password" name="password" placeholder="Password"> <!-- Ensure 'name="password"' -->
                <br>
               @error('username')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
                @error('password')
                    <p class="alert alert-danger">{{ $message }}</p>
                @enderror
                <!-- Display a general error if login fails -->
                @if(session('error'))
                    <p class="alert alert-danger">{{ session('error') }}</p>
                @endif
                <button class="login-btn">Login</button>
            </form>
        </div>
        
    </div>
</body>
</html>