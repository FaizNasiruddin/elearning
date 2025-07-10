<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Quiz</title>
  <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  <style>
    .question-block {
      margin-bottom: 2rem;
      border: 1px solid #ccc;
      padding: 1.2rem;
      border-radius: 8px;
      background-color: #f9f9f9;
    }

    .question-block h3 {
      margin-top: 0;
      margin-bottom: 1rem;
    }

    textarea,
    input[type="text"],
    select {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      font-size: 1rem;
      border-radius: 4px;
      border: 1px solid #ccc;
    }

    .form-buttons {
      display: flex;
      justify-content: space-between;
      gap: 1rem;
      margin-top: 2rem;
    }

    .form-buttons button {
      background-color: var(--main-color);
      color: white;
      padding: 0.8rem 1.5rem;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .form-buttons button:hover {
      background-color: #800000;
    }
  
  </style>
</head>
<body>

   @if(session('role') === 'teacher')
    @include('navbar-teacher')
@elseif(session('role') === 'admin')
    @include('navbar-admin')
@endif

  <div class="content">
    <h1 class="title">Edit Quiz</h1>

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="quizForm" action="/updateQuiz/{{ $quiz->id }}" method="POST">
      @csrf
      @method('POST')

      <div class="form-buttons">
        <button type="submit">Update Quiz</button>
      </div>

      <br>
      <input type="hidden" name="subject_id" value="{{ $quiz->subject_id }}">

      <input type="text" id="quizTitle" name="quizTitle" placeholder="Quiz Title" value="{{ $quiz->title }}" required>

      <div id="questions-container">
        @foreach($quiz->questions as $index => $question)
          <div class="question-block">
            <h3>Question {{ $index + 1 }}</h3>
            <input type="hidden" name="question[{{ $index }}][id]" value="{{ $question->id }}">

            <label>Question Text:</label>
            <textarea name="question[{{ $index }}][text]" rows="3" required>{{ $question->question_text }}</textarea>

            <label>Options:</label>
            <input type="text" name="question[{{ $index }}][options][]" value="{{ $question->option_a }}" required placeholder="Option A">
            <input type="text" name="question[{{ $index }}][options][]" value="{{ $question->option_b }}" required placeholder="Option B">
            <input type="text" name="question[{{ $index }}][options][]" value="{{ $question->option_c }}" required placeholder="Option C">
            <input type="text" name="question[{{ $index }}][options][]" value="{{ $question->option_d }}" required placeholder="Option D">

            <label>Correct Answer:</label>
            <select name="question[{{ $index }}][correct_option]" required>
              <option value="">Select Correct Option</option>
              <option value="A" {{ $question->correct_answer == 'A' ? 'selected' : '' }}>Option A</option>
              <option value="B" {{ $question->correct_answer == 'B' ? 'selected' : '' }}>Option B</option>
              <option value="C" {{ $question->correct_answer == 'C' ? 'selected' : '' }}>Option C</option>
              <option value="D" {{ $question->correct_answer == 'D' ? 'selected' : '' }}>Option D</option>
            </select>
          </div>
        @endforeach
      </div>
    </form>
  </div>

</body>
</html>
