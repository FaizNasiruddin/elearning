<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Content</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
    <style>
        button.selected {
            background-color: var(--third-color);
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
                <button type="button" id="attendanceBtn" onclick="showTable('attendance')">Attendances</button>
                <button type="button" id="quizBtn" onclick="showTable('quiz')">Quizzes</button>
            </div>

            <div>
                <form method="GET" action="/admin-content" style="margin-bottom: 10px;">
                    <select class="formInput" name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    </select>
                    <input type="hidden" name="type" id="tableType" value="{{ request('type', 'attendance') }}">
                </form>
            </div>
        </div>

        <br>

        <!-- Attendance Table -->
        <div id="attendanceTable">
            <div class="table-scroll">
                 <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Subject</th>
                        <th>Created at</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $attendance->subject->name ?? 'No Subject' }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->start_time)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->due_time)->format('d M Y h:i A') }}</td>
                            <td class="last-column">
                                @if ($attendance->subject)
                                    <button class="viewbtn" onclick="location.href='/admin-student-attendance/{{ $attendance->id }}/{{ $attendance->subject->id }}'">
                                        View Student Attendance
                                    </button>
                                @else
                                    <button class="viewbtn" disabled title="Subject not found">
                                        View Student Attendance
                                    </button>
                                @endif
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
        </div>

        <!-- Quiz Table -->
        <div id="quizTable" style="display: none;">
            <div class="table-scroll">
                <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Subject</th>
                        <th>Title</th>
                        <th>Created at</th>
                        <th>Start</th>
                        <th>End</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quizzes as $quiz)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $quiz->subject->name ?? 'No Subject' }}</td>
                            <td>{{ $quiz->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->created_at)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->start_time)->format('d M Y h:i A') }}</td>
                            <td>{{ \Carbon\Carbon::parse($quiz->end_time)->format('d M Y h:i A') }}</td>
                            <td class="last-column">
                                <button class="viewbtn" onclick="location.href='/admin-student-quizmark/{{ $quiz->id }}/{{ $quiz->subject_id }}'">
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
    </div>

    <script>
        function showTable(type) {
            const attendance = document.getElementById('attendanceTable');
            const quiz = document.getElementById('quizTable');
            const tableTypeInput = document.getElementById('tableType');

            const attendanceBtn = document.getElementById('attendanceBtn');
            const quizBtn = document.getElementById('quizBtn');

            if (tableTypeInput) {
                tableTypeInput.value = type;
            }

            if (type === 'attendance') {
                attendance.style.display = 'block';
                quiz.style.display = 'none';

                attendanceBtn.classList.add('selected');
                quizBtn.classList.remove('selected');
            } else {
                attendance.style.display = 'none';
                quiz.style.display = 'block';

                attendanceBtn.classList.remove('selected');
                quizBtn.classList.add('selected');
            }
        }

        // Auto-select the correct button on page load
        document.addEventListener("DOMContentLoaded", () => {
            const params = new URLSearchParams(window.location.search);
            const type = params.get("type") || 'attendance';
            showTable(type);
        });
    </script>
</body>
</html>
