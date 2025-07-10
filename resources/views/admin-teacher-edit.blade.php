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
    <div class="edit">
        <form action="/updateTeacher" method="POST">
            @csrf
            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
            <input type="text" name="teacher_name" value="{{ $teacher->fullname }}">
            <br>
            <button>Update Subject</button>
        </form>
    </div>
    
</body>
</html>