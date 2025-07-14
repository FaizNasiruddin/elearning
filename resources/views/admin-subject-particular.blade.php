<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject Details</title>
    <link rel="stylesheet"  href="{{ asset('css/admin-subject-student.css') }}">
</head>
<body>
    <div class="main">
        <div class="navbar">
            <a href="" class="logo">
                <img class="logo-image" src="{{ asset('images/logo.png') }}" alt="Logo">
            </a>
            <br>
            <a href="/admin-student">
                <div>
                    <img class="student-image" src="{{ asset('images/student-red.png') }}" alt="Subject">
                    <p>Student</p>
                </div>
            </a>
            <br>
            <a href="" class="menu-selected">
                <div>
                    <img class="subject-image" src="{{ asset('images/book-red.png') }}" alt="Subject">
                    <p>Subject</p>
                </div>
            </a>
            <br>
        </div>
        <div class="content">
            <H1>{{ $subject->name }}</H1> <!-- Use $subject here -->
            <div class="add">
                 <H1>{{ $subject->name }}</H1> <!-- Use $subject here -->
            <div class="add">
                <form action="/student-enroll" method="POST">
                    @csrf
                    <input name="subject_id" type="hidden" value="{{ $subject->id }}">
                    <select name="student_id">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->fullname }}</option>
                        @endforeach
                    </select>
                    <button>enroll Student</button>
                </form>
            </div>
            </div>
            <table class="student-list">
                <tr>
                    <tr>
                    <th>Full Name</th>
                    <th>Username</th>
                    <th>Form</th>
                    <th></th>
                    <th></th>
                </tr>
                @foreach($subject->students as $enrolledStudent)
                <tr>
                    <td>{{ $enrolledStudent->fullname }}</td>
                    <td>{{ $enrolledStudent->username }}</td>
                    <td>{{ $enrolledStudent->form }}</td>
                    <td>
                        <form action="">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                    <td><a href="#">Edit</a></td>
                </tr>
                @endforeach
            </table>
            <ul>
        </ul>
        </div>
    </div>
    
</body>
</html>