<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Subjects</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    @include('navbar-teacher') {{-- or a navbar for teachers --}}

    <div class="content">
        <div class="welcome">
                <div>Welcome! {{ $teacher->fullname}}</div>
        </div>
        <div class="subject-list">
            @foreach ($subjects as $subject)
                @php
                    $textColor = strtolower($subject->color) === '#ffffff' ? 'black' : 'white';
                @endphp

                <div 
                    class="subject-card" 
                    style="background-color: {{ $subject->color }}; color: {{ $textColor }}; cursor: pointer;" 
                    onclick="window.location.href='/teacher-subject-content/{{ $subject->id }}'">

                    <p class="subject-name">{{ $subject->name }} (Form {{ $subject->form }})</p>
                    <br>
                    <p class="subject-details">
                        Teacher: {{ $subject->teacher->fullname ?? 'You' }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    
</body>
</html>
