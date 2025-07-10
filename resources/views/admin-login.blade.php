<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/student-login.css') }}">
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
            <p class="login-title">PTBTP eLearning</p>
            <br>
            <p>Administrator</p>
        </div>
        <div class="login">
            <form action="/adminLogin" method="POST">
                @csrf
                <input class="username-form" type="text" name="username" placeholder="Username"> <!-- Ensure 'name="username"' -->
                <br>
                <input class="password-form" type="password" name="password" placeholder="Password"> <!-- Ensure 'name="password"' -->
                <br>
               @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
                <!-- Display a general error if login fails -->
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                <button class="login-btn">Login</button>
            </form>
        </div>
        
    </div>
</body>
</html>