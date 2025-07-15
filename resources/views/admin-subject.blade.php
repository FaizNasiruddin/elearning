<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subject List</title>
    <link rel="stylesheet" href="{{ asset('css/all.css') }}">
</head>
<body>
    
    @include('navbar-admin')

    <div class="content">
        <!-- <div class="add">
                <form action="/addSubject" method="POST">
                    @csrf
                    <input type="text" name="subjectname" placeholder="Subject Name">
                    <br>
                    {{-- <input type="text" name="subjectteacher" placeholder="Teacher"> --}}

                    <select name="subjectteacher">
                        <option value="">-- Select Teacher --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->fullname }}</option>
                        @endforeach
                    </select>
                    <br>
                    <select id="subject" name="subjectform" placeholder="Form">
                        <option value="1">Form 1</option>
                        <option value="2">Form 2</option>
                        <option value="3">Form 3</option>
                        <option value="4">Form 4</option>
                        <option value="5">Form 5</option>
                    </select>
                    <br>
                    <input type="color" name="subjectcolor">
                    <br>
                    <button>Add Subject</button>
                </form>
        </div> -->
        <h1 class="title">Subject List</h1>
        <div class="sort">
            <button onclick="location.href='/admin-subject-add'">Add Subject</button>
            <div>
                <form method="GET" action="/admin-subject" style="margin-bottom: 10px;">
                    <label for="filterForm">Filter by Form:</label>
                    <select class="formInput" name="form" id="filterForm" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="1" {{ request('form') == '1' ? 'selected' : '' }}>Form 1</option>
                        <option value="2" {{ request('form') == '2' ? 'selected' : '' }}>Form 2</option>
                        <option value="3" {{ request('form') == '3' ? 'selected' : '' }}>Form 3</option>
                        <option value="4" {{ request('form') == '4' ? 'selected' : '' }}>Form 4</option>
                        <option value="5" {{ request('form') == '5' ? 'selected' : '' }}>Form 5</option>
                    </select>

                    <!-- Sorting dropdown -->
                    <label for="sort">Sort by:</label>
                    <select class="formInput" name="sort" id="sort" onchange="this.form.submit()">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest (Newest First)</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest (Oldest First)</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
                    </select>
                </form>
            </div>
        </div>
        <br>
        @if ($subjects->isEmpty())
    <p class="alert alert-noti">No subjects available.</p>
@else
    <table>
        <tr>
            <th>Name</th>
            <th>Form</th>
            <th>Teacher</th>
            <th>Color</th>
            <th>Created at</th>
            <th class="buttonCol"></th>
        </tr>
        @foreach ($subjects as $subject)
            <tr>
                <td>{{ $subject->name }}</td>
                <td>{{ $subject->form }}</td>
                <td>
                    @php
                        $teacherName = $teachers->firstWhere('id', $subject->teacher_id);
                    @endphp
                    {{ $teacherName ? $teacherName->fullname : 'No Teacher' }}
                </td>
                <td>
                    <div style="background-color:{{ $subject->color }}; width:80%; height:20px;"></div>
                </td>
                <td>{{ \Carbon\Carbon::parse($subject->end_time)->format('d M Y h:i A') }}</td>
                <td class="buttonCol last-column">
                    <button class="viewbtn" onclick="window.location.href='/admin-subject-particular/{{ $subject->id }}'">View Student</button>
                    <button class="viewbtn" onclick="window.location.href='/admin-subject-content/{{ $subject->id }}'">View Content</button>
                    <a class="editbtn" href="/admin-subject-edit/{{ $subject->id }}" onclick="event.stopPropagation();"></a>
                    <form method="POST" action="/deleteSubject">
                        @csrf
                        <input type="hidden" name="subjectid" value="{{ $subject->id }}">
                        <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this user?')"></button>
                    </form>
                </td>
            </tr>   
        @endforeach
    </table>
@endif
    </div>
</body>
</html>
