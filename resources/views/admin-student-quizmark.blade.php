<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $subject->name }} - Quiz Marks</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/content.css') }}" />
</head>
<body>

 @if(session('role') === 'teacher')
    @include('navbar-teacher')
@elseif(session('role') === 'admin')
    @include('navbar-admin')
@endif

<div class="content">
    <h1 class="title">{{ $subject->name }} - {{ $quiz->title }}</h1>
    <p><strong>Form:</strong> {{ $subject->form }}</p>
    <p><strong>Quiz Duration:</strong> 
        {{ \Carbon\Carbon::parse($quiz->start_time)->format('j M Y g:i A') }} to 
        {{ \Carbon\Carbon::parse($quiz->end_time)->format('j M Y g:i A') }}
    </p>

    <div class="quiz">
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Quiz Status</th>
                    <th>Score</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
               @foreach($students as $student)
    @php
        $mark = $quizMarks->get($student->id);
    @endphp
    <tr>
        <td>{{ $student->fullname }}</td>
        <td>
            @if ($mark)
                <span style="color: green; font-weight: bold;">Attempted</span>
            @else
                <span style="color: red; font-weight: bold;">Not Attempted</span>
            @endif
        </td>
        <td>
            @if ($mark)
                {{ $mark->score }} / {{ $mark->total_questions }}
            @else
                —
            @endif
        </td>
        <td>
            @if ($mark && $mark->total_questions > 0)
                {{ round(($mark->score / $mark->total_questions) * 100) }}%
            @else
                —
            @endif
        </td>
    </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
