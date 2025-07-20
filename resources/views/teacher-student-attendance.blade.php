<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Status</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/admin-student.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    @include('navbar-teacher')

    <div class="content">
        <h1 class="title">{{ $subject->name }} Attendance: <span style="color:green">{{$attendance->start_time}}</span> to <span style="color:red">{{$attendance->due_time}}</span> </h1>
        <div class="sort">
            <div>
                <button onclick="showTable('attendance')">Attendances</button>
                <button onclick="showTable('quiz')">Quizzes</button>
            </div>

            <div>
                <form method="GET" action="/admin-subject" style="margin-bottom: 10px;">
                    <select  class="formInput" name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                    </select>
                </form>
            </div>
        </div>
        <br>
        <table>
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Attendance Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->fullname }}</td>
                        <td>
                            @if (in_array($student->id, $attendanceRecords))
                                <span style="color: green;">Attend</span>
                            @else
                                <span style="color: red;">Absent</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
