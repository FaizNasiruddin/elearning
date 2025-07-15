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
        <form action="/updateStudent" method="POST">
            @csrf
            <input type="hidden" name="student_id" value="{{ $student->id }}">
            <br>
            <input type="text" name="fullname" value="{{ $student->fullname }}">
            <br>
            <input type="text" name="username" value="{{ $student->username }}">
            <br>
            <input type="text" name="password" value="{{ $student->password }}">
            <br>
            <select class="formInput" id="student" name="form">
                <option value="1" {{ $student->form == 1 ? 'selected' : '' }}>Form 1</option>
                <option value="2" {{ $student->form == 2 ? 'selected' : '' }}>Form 2</option>
                <option value="3" {{ $student->form == 3 ? 'selected' : '' }}>Form 3</option>
                <option value="4" {{ $student->form == 4 ? 'selected' : '' }}>Form 4</option>
                <option value="5" {{ $student->form == 5 ? 'selected' : '' }}>Form 5</option>
            </select>
            <br>
            <button>Update Student</button>
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