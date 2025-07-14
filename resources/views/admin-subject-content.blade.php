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
                
                 @if (session('success1'))
                        <div class="alert alert-success">
                            {{ session('success1') }}
                        </div>
                    @endif

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
                                <a href="/admin-student-attendance/{{ $attendance->id }}/{{ $subject->id }}">
                                    View Student Attendance
                                </a>
                            </td>
                            <td class="buttonCol">
                                <form action="/deleteAttendance" method="POST">
                                    @csrf
                                    <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                                    <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this quiz?')"></button>

                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-noti">No attendance created.</p>
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
                    <br>
                </div>

                        @if (session('success2'))
                        <div class="alert alert-success">
                            {{ session('success2') }}
                        </div>
                    @endif

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
                            <td class="buttonCol">
                                <form action="/deleteFile" method="POST">
                                    @csrf
                                    <input type="hidden" name="file_id" value="{{ $file->id }}">
                                    <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this quiz?')"></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-noti">No files uploaded.</p>
                @endif
            </div>

            <div class="quiz">
                <div class="contents-add">
                    <button type="button" onclick="window.location.href='/admin-quiz/{{ $subject->id }}'">Add Quiz</button>
                   
                </div>

                 @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($quizzes->count() > 0)
                <table>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <td>
                                <small>Upload at: {{ \Carbon\Carbon::parse($quiz->created_at)->format('j M Y g:i A') }}</small>
                            </td>
                            <td>
                                <small>
                                    Start: {{ \Carbon\Carbon::parse($quiz->start_time)->format('j M Y g:i A') }}<br>
                                    end: {{ \Carbon\Carbon::parse($quiz->end_time)->format('j M Y g:i A') }}
                                </small>
                            </td>
                            <td>{{ $quiz->title }}</td>
                            <td>
                                <a href="/admin-student-quizmark/{{ $quiz->id }}/{{ $subject->id }}">View Student Mark</a>
                            </td>
                            <td>
                                <a href="/admin-quiz-edit/{{ $quiz->id }}">Edit Quiz</a>
                            </td>
                            <td class="buttonCol">
                                <form action="/deleteQuiz" method="POST">
                                    @csrf
                                    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">
                                    <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this quiz?')"></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
                @else
                    <p class="alert alert-noti">No quiz added.</p>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
