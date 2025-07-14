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
     @if(session('role') === 'teacher')
    @include('navbar-teacher')
@elseif(session('role') === 'admin')
    @include('navbar-admin')
@endif

    <div class="content">
    <h1 class="title">{{ $subject->name }} (Form {{$subject->form}}) Attendance:
        <span style="color:green">{{ $attendance->start_time }}</span> to
        <span style="color:red">{{ $attendance->due_time }}</span>
    </h1>

    <br>

    @if ($students->isEmpty())
        <div class="alert alert-noti">
            No students found for this subject.
        </div>
    @else
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
    @endif
</div>

</body>
</html>
