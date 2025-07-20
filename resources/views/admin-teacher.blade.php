<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teacher Manager</title>
  <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  <style>
    .toggle-visibility {
      background: none;
      border: none;
      cursor: pointer;
      padding: 0;
      margin-left: 5px;
    }

    .toggle-visibility img {
      width: 20px;
      height: 20px;
    }

    .table-scroll {
      overflow-x: auto;
      max-width: 100%;
    }

    .table-scroll table {
      width: 100%;
      min-width: 700px;
      border-collapse: collapse;
    }

    th, td {
      white-space: nowrap;
    }
  </style>
</head>
<body>
  @include('navbar-admin')

  <div class="content">
    <h1 class="title">Teacher Manager</h1>

    <div class="sort">
      <button onclick="location.href='/admin-teacher-add'">Add Teacher Account</button>
      <form method="GET" action="/admin-teacher" style="margin-bottom: 10px;">
        <select class="formInput" name="sort" id="sort" onchange="this.form.submit()">
          <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
          <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
          <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Username A-Z</option>
          <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Username Z-A</option>
        </select>
      </form>
    </div>

    <br>

    @if ($teachers->isNotEmpty())
    <div class="table-scroll">
      <table>
        <tr>
          <th>Full Name</th>
          <th>IC Number</th>
          <th>Password</th>
          <th>Created at</th>
          <th></th>
        </tr>
        @foreach ($teachers as $teacher)
        <tr>
          <td>{{ $teacher->fullname }}</td>
          <td>
            <span class="masked" data-value="{{ $teacher->username }}">•••••</span>
            <button class="toggle-visibility" onclick="toggleVisibility(this)">
              <img src="{{ asset('icon/eye-close.png') }}" alt="Toggle Username">
            </button>
          </td>
          <td>
            <span class="masked" data-value="{{ $teacher->password }}">•••••</span>
            <button class="toggle-visibility" onclick="toggleVisibility(this)">
              <img src="{{ asset('icon/eye-close.png') }}" alt="Toggle Password">
            </button>
          </td>
          <td>{{ \Carbon\Carbon::parse($teacher->created_at)->format('d-m-Y h:i A') }}</td>
          <td class="buttonCol last-column">
            <a class="editbtn" href="/admin-teacher-edit/{{ $teacher->id }}" onclick="event.stopPropagation();"></a>
            <form method="POST" action="/deleteTeacher">
              @csrf
              <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
              <button class="deletebtn" type="submit" onclick="return confirm('Are you sure you want to delete this user?')"></button>
            </form>
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    
    @else
    <div class="alert alert-noti">No teacher available.</div>
    @endif
  </div>

  <script>
    function toggleVisibility(button) {
      const span = button.previousElementSibling;
      const img = button.querySelector('img');
      const isMasked = span.classList.contains('masked');

      if (isMasked) {
        span.textContent = span.getAttribute('data-value');
        span.classList.remove('masked');
        img.src = "{{ asset('icon/eye-open.png') }}";
      } else {
        span.textContent = '•••••';
        span.classList.add('masked');
        img.src = "{{ asset('icon/eye-close.png') }}";
      }
    }
  </script>
</body>
</html>
