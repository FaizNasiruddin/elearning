<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Details</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>

    @include('navbar-admin')

    <div class="content">
<div class="add">
        <form action="/student-enroll" method="POST">
            @csrf
            <input name="subject_id" type="hidden" value="{{ $subject->id }}">

            <select class="formInput" name="student_id">
                <option value="" disabled selected>Select Student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->fullname }} ({{$student->username}})</option>
                @endforeach
            </select>

            @error('student_id')
                <div class="alert alert-danger" style="color: red;">{{ $message }}</div>
            @enderror

            <button>Enroll Student</button>
        </form>
    </div>
    </div>
</body>
</html>
