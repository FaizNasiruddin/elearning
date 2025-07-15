<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Status</title>
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
            <span style="color:green">{{ \Carbon\Carbon::parse($attendance->start_time)->format('d M Y h:i A') }}</span> to
            <span style="color:red">{{ \Carbon\Carbon::parse($attendance->due_time)->format('d M Y h:i A') }}</span>
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
                        <th>Record at</th>
                        <th class="last-column">Attendance Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        @php
                            $record = $attendanceRecords->firstWhere('student_id', $student->id);
                        @endphp
                        <tr>
                            <td>{{ $student->fullname }}</td>
                            <td>
                                @if ($record)
                                    {{ \Carbon\Carbon::parse($record->created_at)->format('d M Y h:i A') }}
                                @else
                                    <span style="color: gray;">-</span>
                                @endif
                            </td>
                            <td class="last-column">
                                @if ($record)
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
