<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $subject->name }} - Files</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin-subject-content.css') }}" />
</head>
<body>

    @if(session('role') === 'teacher')
    @include('navbar-teacher')
@elseif(session('role') === 'admin')
    @include('navbar-admin')
@endif

    <div class="content">
        <h2 class="title">{{ $subject->name }} (Form {{ $subject->form}})</h2>
        <div class="contents">
            <div class="attendance">
                <div class="contents-add">
                    <form action="/addAttendance" method="POST">
                        @csrf
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}" />

                        <label>From:</label><br>
                        <input type="date" name="start_date" required>
                        <input type="time" name="start_time" value="08:00" required><br><br>

                        <label>To:</label><br>
                        <input type="date" name="due_date" required>
                        <input type="time" name="due_time" value="08:00" required><br><br>

                        <button type="submit">Add Attendance</button>
                    </form>
                </div>

                @if ($attendances->count() > 0)
                <table>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td>
                                <small>Created at: {{ \Carbon\Carbon::parse($attendance->created_at)->format('j M Y g:i A') }}</small>
                            </td>
                            <td>
                                <small>
                                    Start: {{ \Carbon\Carbon::parse($attendance->start_time)->format('j M Y g:i A') }}<br>
                                    End: {{ \Carbon\Carbon::parse($attendance->due_time)->format('j M Y g:i A') }}
                                </small>
                            </td>
                            <td>{{ $attendance->password }}</td>
                            <td>
                                <a href="/teacher-student-attendance/{{ $attendance->id }}/{{ $subject->id }}">
                                    View Student Attendance
                                </a>
                            </td>
                            <td>
                                <form action="/deleteAttendance" method="POST">
                                    @csrf
                                    <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                                    <button>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-danger">No attendance created.</p>
                @endif
            </div>

            <div class="note">
                <div class="contents-add">
                    <form action="/file-upload" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $subject->id }}" />
                        <label for="file">Choose file:</label>
                        <input type="file" name="file" required /><br /><br />
                        <button type="submit">Upload File</button>
                    </form>
                    
                @php $files = $files ?? collect(); @endphp

                @if ($files->count() > 0)
                <table>
                    @foreach ($files as $file)
                        <tr>
                            <td>
                                <small>Upload at: {{ \Carbon\Carbon::parse($file->created_at)->format('j M Y g:i A') }}</small>
                            </td>
                            <td>{{ $file->filename }}</td>
                            <td>
                                <a href="{{ route('view.file', $file->id) }}" target="_blank">View File</a>
                            </td>
                            <td>
                                <form action="/deleteFile" method="POST">
                                    @csrf
                                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                                    <button>Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-danger">No files uploaded yet.</p>
                @endif
                </div>

            </div>

            <div class="quiz">
                <div class="contents-add">
                    <button type="button" onclick="window.location.href='/teacher-quiz/{{ $subject->id }}'">Add Quiz</button>
                </div>

                @if ($quizzes->count() > 0)
                <table>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($quiz->created_at)->format('j M Y g:i A') }}</small>
                            </td>
                            <td>
                                <small>
                                    {{ \Carbon\Carbon::parse($quiz->start_time)->format('j M Y g:i A') }}<br>
                                    {{ \Carbon\Carbon::parse($quiz->end_time)->format('j M Y g:i A') }}
                                </small>
                            </td>
                            <td>{{ $quiz->title }}</td>
                            <td>
                                <a href="/teacher-quiz-edit/{{ $quiz->id }}">Edit Quiz</a>
                            </td>
                            <td>
                                <form action="/deleteQuiz" method="POST">
                                    @csrf
                                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                    <img src="" alt="">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-danger">No quiz added.</p>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
