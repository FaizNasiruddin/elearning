<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/admin-student.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    @include('navbar-admin')
    <div class="content">
        <!-- <div class="add">
            <form action="/registerStudent" method="POST">
                @csrf
                <input type="text" placeholder="Name" name="fullname">
                <br>
                <input type="text" placeholder="Username" name="username">
                <br>
                <input type="text" placeholder="Password" name="password">
                <br>
                <label for="number">Form:</label>
                <select name="form" id="form">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <br>
                <button type="submit">Add Student</button>
            </form>

            @if ($errors->any())
            <div class="error-message">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div> -->
        <h1 class="title">Student Manager</h1>
        <div class="sort">
            <button onclick="location.href='/admin-student-add'">Add Student Account</button>
            <div>
                <form method="GET" action="/admin-student" style="margin-bottom: 10px;">
                    <label for="filterForm">Filter by Form:</label>
                    <select class="formInput" class="formInput" name="form" id="filterForm" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="1" {{ request('form') == '1' ? 'selected' : '' }}>Form 1</option>
                        <option value="2" {{ request('form') == '2' ? 'selected' : '' }}>Form 2</option>
                        <option value="3" {{ request('form') == '3' ? 'selected' : '' }}>Form 3</option>
                        <option value="4" {{ request('form') == '4' ? 'selected' : '' }}>Form 4</option>
                        <option value="5" {{ request('form') == '5' ? 'selected' : '' }}>Form 5</option>
                    </select>

                    <!-- Sorting dropdown -->
                    <label for="sort">Sort by:</label>
                    <select class="formInput" class="formInput" name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                    </select>
                </form>
            </div>
            
        </div>
        <br>
        <table>
            <tr>
                <th>Full Name</th>
                <th>IC Number</th>
                <th>Password</th>
                <th>Form</th>
                <th>Created at</th>
                <th></th>
            </tr>
            @foreach ($students as $student)
    <tr>
        <td>{{ $student->fullname }}</td>
        <td>{{ $student->username }}</td>
        <td>{{ $student->password }}</td>
        <td>{{ $student->form }}</td>
        <td>{{ \Carbon\Carbon::parse($student->created_at)->format('d-m-Y h:i A') }}</td>
        <td class="buttonCol last-column" data-label="Delete">
            <a class="editbtn" href="/admin-student-edit/{{ $student->id }}" onclick="event.stopPropagation();"></a>

            <form method="POST" action="/deleteStudent">
                @csrf
                <input type="hidden" name="studentid" value="{{ $student->id }}">
                <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this user?')"></button>
            </form>
        </td>
        <!-- <td data-label="Edit">
            
        </td> -->
    </tr>
@endforeach
        </table>
    </div>

</body>
</html>
