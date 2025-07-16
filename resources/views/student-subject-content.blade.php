<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $subject->name }} - Files</title>
  <link rel="stylesheet" href="{{ asset('css/all.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/content.css') }}" />
</head>
<body>

  @include('navbar')

  <div class="content">
    <h1 class="title">{{ $subject->name }} (Form {{ $subject->form }})</h1>
    <div class="contents">

      <!-- Attendance Section -->
      <div class="attendance">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th colspan="2" style="text-align:center;">Attendance</th>
              </tr>
            </thead>
            <tbody>
              @if ($attendances->count() > 0)
                @foreach ($attendances as $attendance)
                  <tr>
                    <td>
                      <strong>Attendance #{{ $loop->iteration }}</strong><br>
                      <small>
                        Starts: {{ \Carbon\Carbon::parse($attendance->start_time)->format('j M Y g:i A') }}<br>
                        Ends: {{ \Carbon\Carbon::parse($attendance->due_time)->format('j M Y g:i A') }}
                      </small>
                    </td>
                    <td class="last-column">
                      @php
                        $now = \Carbon\Carbon::now('Asia/Kuala_Lumpur');
                        $start = \Carbon\Carbon::parse($attendance->start_time, 'Asia/Kuala_Lumpur');
                        $due = \Carbon\Carbon::parse($attendance->due_time, 'Asia/Kuala_Lumpur');
                      @endphp

                      @if ($attendanceRecords->has($attendance->id))
                        <span style="color: green;">Present</span>
                      @elseif ($now->lt($start))
                        <span style="color: gray;">Not started yet ({{ $start->format('j M Y g:i A') }})</span>
                      @elseif ($now->gt($due))
                        <span style="color: red;">Attendance closed</span>
                        <!-- <span style="color: red;">Attendance closed ({{ $due->format('j M Y g:i A') }})</span> -->
                      @else
                        <form action="/tickAttendance" method="POST">
                          @csrf
                          <input type="hidden" name="student_id" value="{{ $student }}">
                          <input type="hidden" name="attendance_id" value="{{ $attendance->id }}">
                          <input class="formInput" type="text" name="password" placeholder="Enter Code" required>
                          <br>
                          <br>
                          <button type="submit">
                            Mark as Present
                          </button>
                          <br>
                          <br>
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </form>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="2">No attendance sessions yet.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

      <!-- Note Section -->
      <div class="note">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th colspan="2" style="text-align:center;">Learning Material</th>
              </tr>
            </thead>
            <tbody>
              @if ($files->count() > 0)
                @foreach ($files as $file)
                  <tr>
                    <td>
                      <strong>{{ $file->filename }}</strong><br>
                      <small>
                        Uploaded: {{ \Carbon\Carbon::parse($file->created_at)->format('j M Y g:i A') }}
                      </small>
                    </td>
                    <td class="last-column">
                      <button class="viewbtn" onclick="window.open('{{ route('view.file', $file->id) }}', '_blank')">
                        View File
                    </button>
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="2">No files uploaded yet.</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

      <!-- Quiz Section -->
      <div class="quiz">
        <div class="table-responsive">
          <table>
            <thead>
              <tr>
                <th colspan="3" style="text-align:center;">
                  Quiz
                  <br>
                  <br>
                    @if (session('success'))
                    <p class="alert alert-success">
                        {{ session('success') }}
                    </p>
                @endif
</th>
              </tr>
            </thead>
            <tbody>
              @if ($quizzes->count() > 0)
                @foreach ($quizzes as $quiz)
                  <tr>
                    <td>
                      <strong>{{ $quiz->title }}</strong><br>
                      <small>
                        Starts: {{ \Carbon\Carbon::parse($quiz->start_time)->format('j M Y g:i A') }}<br>
                        Ends: {{ \Carbon\Carbon::parse($quiz->end_time)->format('j M Y g:i A') }}
                      </small>
                    </td>
                    <td class="last-column">
                      @php
                        $now = \Carbon\Carbon::now('Asia/Kuala_Lumpur');
                        $start = \Carbon\Carbon::parse($quiz->start_time, 'Asia/Kuala_Lumpur');
                        $end = \Carbon\Carbon::parse($quiz->end_time, 'Asia/Kuala_Lumpur');
                        $result = $quizResults->get($quiz->id);
                      @endphp

                      @if ($result)
                        <span style="color: blue;">
                          {{ $result->score }}/{{ $result->total_questions }}
                          ({{ round(($result->score / $result->total_questions) * 100) }}%)
                        </span>
                      @elseif ($now->lt($start))
                        <span style="color: gray;">Quiz not started</span>
                      @elseif ($now->gt($end))
                        <span style="color: red;">Quiz closed</span>
                      @else
                        <a href="/student-quiz/{{ $quiz->id }}"
                           onclick="return confirm('Are you sure you want to start the quiz now?\nTime limit is {{ $quiz->time_limit }} minute{{ $quiz->time_limit > 1 ? 's' : '' }}.')"
                           style="color: green; font-weight: bold;">
                          Attempt Quiz
                        </a> 
                        
                      @endif
                    </td>
                  </tr>
                @endforeach
              @else
                <tr>
                  <td colspan="3">No quizzes available</td>
                </tr>
              @endif
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

</body>
</html>
