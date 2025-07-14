<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Content</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
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
                <button type="button" onclick="showTable('attendance')">Attendances</button>
                <button type="button" onclick="showTable('quiz')">Quizzes</button>
            </div>

            <div>
                <form method="GET" action="/admin-content" style="margin-bottom: 10px;">
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
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $attendance->subject->name ?? 'No Subject' }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->start_time)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->due_time)->format('d M Y h:i A') }}</td>
                            <td>
                                <button class="last-column" onclick="location.href='/admin-student-attendance/{{ $attendance->id }}/{{ $attendance->subject->id }}'">
                                    View Student Attendance
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"><div class="alert alert-noti">No attendance records found.</div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Quiz Table -->
        <div id="quizTable" style="display: none;">
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
                    @forelse($quizzes as $quiz)
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
                    @empty
                        <tr>
                            <td colspan="6"><div class="alert alert-noti">No quizzes found.</div></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function showTable(type) {
            const attendance = document.getElementById('attendanceTable');
            const quiz = document.getElementById('quizTable');

            if (type === 'attendance') {
                attendance.style.display = 'block';
                quiz.style.display = 'none';
            } else {
                attendance.style.display = 'none';
                quiz.style.display = 'block';
            }
        }

        // Default show Attendance on page load
        document.addEventListener("DOMContentLoaded", () => {
            showTable('attendance');
        });
    </script>
</body>
</html>
