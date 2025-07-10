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
       @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>There were some problems with your input:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

        <form action="/updateSubject" method="POST">
            @csrf
            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
            <input type="text" name="subjectname" value="{{ $subject->name }}">
            <select name="subjectteacher">
                <option value="">-- Select Teacher --</option>
                @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $subject->teacher_id==$teacher->id?"selected":""}}>{{ $teacher->fullname }}</option>
                @endforeach
            </select>
            <br>
            <input type="color" name="subjectcolor" value="{{ $subject->color }}" >
            <br>
            <br>
            <!-- <select id="subject" name="subjectform">
                <option value="1" {{ $subject->form == 1 ? 'selected' : '' }}>Form 1</option>
                <option value="2" {{ $subject->form == 2 ? 'selected' : '' }}>Form 2</option>
                <option value="3" {{ $subject->form == 3 ? 'selected' : '' }}>Form 3</option>
                <option value="4" {{ $subject->form == 4 ? 'selected' : '' }}>Form 4</option>
                <option value="5" {{ $subject->form == 5 ? 'selected' : '' }}>Form 5</option>
            </select> -->
            <button>Update Subject</button>
        </form>
        
    </div>
</body>
</html>