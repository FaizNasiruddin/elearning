<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet"  href="{{ asset('css/all.css') }}">
</head>
<body>

     @include('navbar-admin')
     <div class="content">
        <div class="add">
                <form action="/registerTeacher" method="POST">
                    @csrf
                    <input type="text" placeholder="Name" name="fullname"><br>
                    <input type="text" placeholder="Username" name="username"><br>
                    <input type="text" placeholder="Password" name="password"><br>
                    <button type="submit">Add Teacher</button>
                </form>
                
                @if ($errors->any())
                <br>
                <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach
                </div>
                @endif
            </div>
     </div>
</body>
</html>