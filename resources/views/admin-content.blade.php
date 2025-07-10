<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <title>Subject Content</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    @if(session('role') === 'teacher')
        @include('navbar-teacher')
    @elseif(session('role') === 'admin')
        @include('navbar-admin')
    @endif

    <div class="content">
        <h1 class="title">Content</h1>

        <div class="sort">
            <div>
                <button onclick="showTable('attendance')">Attendances</button>
                <button onclick="showTable('quiz')">Quizzes</button>
            </div>

            <div>
                <form method="GET" action="/admin-subject" style="margin-bottom: 10px;">
                    <label for="sort">Sort by:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                    </select>
                </form>
            </div>
        </div>

        <br>

        <!-- Attendance Table -->
        <div id="attendanceTable">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>ID</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->subject->name ?? 'No Subject' }}</td>
                            <td>{{ $attendance->id ?? 'No ID' }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->start_time)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->due_time)->format('d M Y h:i A') }}</td>
                            <td>
                                <button class="last-column" onclick="location.href='/admin-student-attendance/{{ $attendance->id }}/{{ $attendance->subject->id }}'">
                                    View Student Attendance
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Quiz Table -->
        <div id="quizTable" class="hidden">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Title</th>
                        <th>Created</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quizzes as $quiz)
                        <tr>
                            <td>{{ $quiz->subject->name ?? 'No Subject' }}</td>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->created_at)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->start_time)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->end_time)->format('d M Y h:i A') }}</td>
                            <td class="last-column">
                                <button onclick="location.href='/admin-student-quizmark/{{ $quiz->id }}/{{ $quiz->subject_id }}'">
                                    Student Quiz Mark
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTable(type) {
            const attendance = document.getElementById('attendanceTable');
            const quiz = document.getElementById('quizTable');

            if (type === 'attendance') {
                attendance.classList.remove('hidden');
                quiz.classList.add('hidden');
            } else {
                quiz.classList.remove('hidden');
                attendance.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
