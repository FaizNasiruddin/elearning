<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    @include('navbar-admin')

    <div class="content">
 <div class="add">
    <p style="font-size:20px; color:gray">Add Student Account</p>
    <br>
        <form action="/registerStudent" method="POST">
            @csrf
            <input type="text" placeholder="Name" name="fullname">
            <br>
            <input type="text" placeholder="IC Number" name="username">
            <br>
            <input type="text" placeholder="Password" name="password">
            <br>
            <select class="formInput" name="form" id="form">
                <option value="1">Form 1</option>
                <option value="2">Form 2</option>
                <option value="3">Form 3</option>
                <option value="4">Form 4</option>
                <option value="5"> Form 5</option>
            </select>
            <br>
            <button type="submit">Add Student</button>
        </form>

        @if ($errors->any())
        <br>
        <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                   <p>{{ $error }}</p>
                @endforeach
        </div>
        @endif
    </div>
    </div>
</body>
</html>