<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />

</head>
<body>
    @include('navbar')

    <div class="content">
        <div class="profile">
            <h2>{{ $student->fullname}}</h2>
            <br>
            <p> Registered Subject: |
                @foreach ($subjects as $subject)
                    {{ $subject->name }} |
                @endforeach
            </p>
        </div>
        <div class="contents">
            <div>
                <table>
                        @foreach ($attendances as $attendance)
                                

                            <tr>
                                <td><strong>{{ $attendance->subject->name ?? 'No Subject' }}</strong></td>
                                <!-- <td>
                                <small>
                                Created at: {{ \Carbon\Carbon::parse($attendance->created_at)->format('j M Y g:i A') }}
                                </small>
                            </td> -->
                            <td>
                                <small>
                                    Start: {{ \Carbon\Carbon::parse($attendance->start_time)->format('j M Y g:i A') }}
                                    <br>
                                    End: {{ \Carbon\Carbon::parse($attendance->due_time)->format('j M Y g:i A') }}
                                </small>
                            </td>
                                <td>
                                    @if ($attendanceRecords->has($attendance->id))
                                        <span style="color: green;">Present</span>
                                    @else
                                        <span style="color: red;">Absent</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                </table>
              
            </div>
            <div>
                <table>
        @foreach ($quizzes as $quiz)
            <tr>
                <td><strong>{{ $quiz->subject->name ?? 'No Subject' }}</strong><br>
                <small>{{ $quiz->title }}</small></td>
                <!-- <td>
                    <small>
                        Created at: {{ \Carbon\Carbon::parse($quiz->created_at)->format('j M Y g:i A') }}
                    </small>
                </td> -->
                <td>
                    <small>
                        Created at: {{ \Carbon\Carbon::parse($quiz->start_time)->format('j M Y g:i A') }}
                    </small>
                    <br>
                    <small>
                        Created at: {{ \Carbon\Carbon::parse($quiz->end_time)->format('j M Y g:i A') }}
                    </small>
                </td>
                <td>
                    @if ($quizMarks->has($quiz->id))
                        <span style="color: green;">Taken</span>
                    @else
                        <span style="color: red;">Not Taken</span>
                    @endif
                </td>
            </tr>
        @endforeach
</table>
            </div>
        </div>
    </div>
</body>
</html>