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
            <form action="/registerTeacher" method="POST">
                @csrf
                <input type="text" placeholder="Name" name="fullname">
                <br>
                <button type="submit">Add Teacher</button>
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
        <h1 class="title">Teacher List</h1>
        <div class="sort">
             <button onclick="location.href='/admin-teacher-add'">Add Teacher Account</button>
            <form method="GET" action="/admin-teacher" style="margin-bottom: 10px;">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                </select>
            </form>
        </div>
        <br>
        <table>
            <tr>
                <th>Full Name</th>
                <th>username</th>
                <th>password</th>
                <th></th>
            </tr>
            @foreach ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->fullname }}</td>
                    <td>{{ $teacher->username }}</td>
                    <td>{{ $teacher->password }}</td>
                    <td class="buttonCol last-column">
                        <form method="POST" action="/deleteTeacher">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                            <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this user?')"></button>
                        </form>
                        <a class="editbtn" href="/admin-teacher-edit/{{ $teacher->id }}" onclick="event.stopPropagation();"></a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html>
