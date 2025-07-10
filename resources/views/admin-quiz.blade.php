<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Quiz</title>
  <link rel="stylesheet" href="{{ asset('css/all.css') }}">
  <style>

    .title {
      margin-bottom: 1.5rem;
    }

    .alert-success {
      color: green;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    .alert-danger {
      color: red;
      margin-bottom: 1rem;
    }

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
      box-sizing: border-box;
    }

    .form-buttons {
      display: flex;
      justify-content: flex-start;
      gap: 1rem;
      margin-top: 2rem;
    }

    .form-buttons button {
      background-color: var(--main-color, #0066cc);
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

    .remove-btn {
      background-color: #e74c3c;
      color: white;
      border: none;
      padding: 6px 12px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
    }

    .remove-btn:hover {
      background-color: #c0392b;
    }

  </style>
</head>
<body>

  @include('navbar-admin')

  <div class="content">
    <h1 class="title">Create a New MCQ Quiz</h1>

    @if(session('success'))
      <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert-danger">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form id="quizForm" action="/createQuiz" method="POST">
      @csrf
      <input type="hidden" name="subject_id" value="{{ $subject_id }}">

      <label for="start_date">Start Date:</label>
      <input type="date" name="start_date" id="start_date" required>
      <input type="time" name="start_time" id="start_time" value="08:00" required>

      <label for="end_date">End Date:</label>
      <input type="date" name="end_date" id="end_date" required>
      <input type="time" name="end_time" id="end_time" value="08:00" required>

      <label for="time_limit">Time Limit (in minutes):</label>
      <input type="number" name="time_limit" id="time_limit" min="1" placeholder="E.g. 30" required>
      <br>
      <br>
      <input type="text" id="quizTitle" name="quizTitle" placeholder="Enter quiz title" required>

      <div id="questions-container">
        <!-- Questions will be dynamically added here -->
      </div>

      <div class="form-buttons">
        <button type="button" onclick="addQuestion()">Add Question</button>
        <button type="submit">Save Quiz</button>
      </div>
    </form>
  </div>

  <script>
    let questionCount = 0;

    function addQuestion() {
      questionCount++;
      const container = document.getElementById('questions-container');

      const questionDiv = document.createElement('div');
      questionDiv.className = 'question-block';
      questionDiv.innerHTML = `
        <h3>Question ${questionCount}</h3>

        <label>Question Text:</label>
        <textarea name="question[${questionCount}][text]" rows="3" required></textarea>

        <label>Options:</label>
        <input type="text" name="question[${questionCount}][options][]" placeholder="Option A" required>
        <input type="text" name="question[${questionCount}][options][]" placeholder="Option B" required>
        <input type="text" name="question[${questionCount}][options][]" placeholder="Option C" required>
        <input type="text" name="question[${questionCount}][options][]" placeholder="Option D" required>

        <label>Correct Answer:</label>
        <select name="question[${questionCount}][correct_option]" required>
          <option value="">Select Correct Option</option>
          <option value="A">Option A</option>
          <option value="B">Option B</option>
          <option value="C">Option C</option>
          <option value="D">Option D</option>
        </select>

        <button type="button" class="remove-btn" onclick="removeQuestion(this)">Remove Question</button>
      `;

      container.appendChild(questionDiv);
    }

    function removeQuestion(button) {
      const block = button.closest('.question-block');
      block.remove();
    }
  </script>

</body>
</html>
