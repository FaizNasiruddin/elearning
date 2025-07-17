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
    <p style="font-size:20px; color:gray">Edit Teacher Account</p>
        <form action="/updateTeacher" method="POST">
            @csrf
            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            <input type="text" placeholder="Full Name" name="teacher_name" value="{{ $teacher->fullname }}">
            <input type="text" placeholder="IC Number" name="teacher_username" value="{{ $teacher->username }}">
            <input type="text" placeholder="Password" name="teacher_password" value="{{ $teacher->password }}">
            <br>
            <button>Update Teacher</button>
        </form>
        <br>
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                {{ $error }}
                <br>
            @endforeach
        </ul>
    </div>
@endif
    </div>
    </div>
</body>
</html>