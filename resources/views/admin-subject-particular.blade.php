<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Details</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    
    @include('navbar-admin')

    <div class="content">
        <h1 class="title">{{ $subject->name }} (Form {{ $subject->form }})</h1>

        <div class="sort">
            <div>
                <button onclick="location.href='/admin-enroll-student/{{ $subject->id }}'">Enroll Student</button>
            </div>
            <!-- <div>
                <form method="GET" action="/admin-student" style="margin-bottom: 10px;">
                    <label for="sort">Sort by:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                    </select>
                </form>
            </div> -->
        </div>

        <br>

  @if($subject->students->isEmpty())
    <p class="alert alert-noti">No students enrolled yet.</p>
@else
    <table class="student-list" id="studentTable">
        <tr>
            <th>Full Name</th>
            <th>IC Number</th>
            <th>Form</th>
            <th></th>
        </tr>
        @foreach($subject->students as $enrolledStudent)
            <tr>
                <td>{{ $enrolledStudent->fullname }}</td>
                <td>{{ $enrolledStudent->username }}</td>
                <td>{{ $enrolledStudent->form }}</td>
                <td class="last-column">
                    <form class="buttonCol" action="/deleteEnrolledStudent" method="POST">
                        @csrf
                        <input type="hidden" name="student_id" value="{{ $enrolledStudent->id }}">
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        <button class="deletebtn" type="submit"></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endif



    </div>
    
</body>
</html>
