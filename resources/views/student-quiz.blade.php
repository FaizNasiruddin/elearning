<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student Quiz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    :root {
      --primary-color: #4CAF50;
      --accent-color: #f44336;
      --bg-color: #f9f9f9;
      --text-color: #333;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg-color);
      color: var(--text-color);
      margin: 0;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: var(--primary-color);
      margin-bottom: 10px;
    }

    #countdown {
      text-align: center;
      font-size: 1.3em;
      font-weight: bold;
      margin-bottom: 30px;
      color: var(--accent-color);
    }

    form {
      max-width: 700px;
      margin: 0 auto;
      background: #fff;
      padding: 25px 30px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .question-block {
      display: none;
      animation: fadeIn 0.3s ease-in-out;
    }

    .question-block.active {
      display: block;
    }

    .question-block h3 {
      margin-bottom: 10px;
      color: #555;
    }

    .question-block p {
      margin-bottom: 15px;
      font-size: 1.1em;
    }

    label {
      display: block;
      margin-bottom: 10px;
      padding: 10px;
      background-color: #f1f1f1;
      border-radius: 6px;
      transition: background-color 0.2s ease-in-out;
      cursor: pointer;
    }

    label:hover {
      background-color: #e0e0e0;
    }

    input[type="radio"] {
      margin-right: 10px;
      transform: scale(1.2);
    }

    .navigation-buttons {
      margin-top: 30px;
      text-align: center;
    }

    .navigation-buttons button {
      background-color: var(--primary-color);
      color: white;
      border: none;
      padding: 10px 20px;
      margin: 0 10px;
      font-size: 1em;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .navigation-buttons button:hover {
      background-color: #388e3c;
    }

    #submitBtn {
      background-color: var(--accent-color);
    }

    #submitBtn:hover {
      background-color: #d32f2f;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 600px) {
      form {
        padding: 20px;
      }

      .navigation-buttons button {
        display: block;
        width: 100%;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>

  <h1>Quiz: {{ $quiz->title ?? 'Sample Quiz' }}</h1>
  <div id="countdown">Time Left: <span id="timer">{{ $quiz->time_limit }}:00</span></div>

  <form id="studentQuizForm" action="/submitQuiz" method="POST">
    @csrf
    <input type="hidden" name="quiz_id" value="{{ $quiz->id }}">

    <div id="questionsWrapper">
      @foreach($questions as $index => $question)
        <div class="question-block {{ $index === 0 ? 'active' : '' }}" data-index="{{ $index }}">

          <h3>Question {{ $index + 1 }}</h3>
          <p>{{ $question->question_text }}</p>

          @php
            $options = ['A' => $question->option_a, 'B' => $question->option_b, 'C' => $question->option_c, 'D' => $question->option_d];
          @endphp

          @foreach($options as $key => $option)
            <label>
              <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" required>
              {{ $key }}. {{ $option }}
            </label>
          @endforeach

        </div>
      @endforeach
    </div>

    <div class="navigation-buttons">
      <button type="button" onclick="previousQuestion()">Previous</button>
      <button type="button" onclick="nextQuestion()">Next</button>
      <button type="submit" id="submitBtn" style="display: none;">Submit Quiz</button>
    </div>
  </form>

  <script>
    // Navigation logic
    let currentIndex = 0;
    const questions = document.querySelectorAll('.question-block');
    const submitBtn = document.getElementById('submitBtn');
    const prevBtn = document.querySelector('button[onclick="previousQuestion()"]');
    const nextBtn = document.querySelector('button[onclick="nextQuestion()"]');

    function showQuestion(index) {
      questions.forEach(q => q.classList.remove('active'));
      questions[index].classList.add('active');

      prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
      nextBtn.style.display = index === questions.length - 1 ? 'none' : 'inline-block';
      submitBtn.style.display = index === questions.length - 1 ? 'inline-block' : 'none';
    }

    function nextQuestion() {
      if (currentIndex < questions.length - 1) {
        currentIndex++;
        showQuestion(currentIndex);
        scrollToTop();
      }
    }

    function previousQuestion() {
      if (currentIndex > 0) {
        currentIndex--;
        showQuestion(currentIndex);
        scrollToTop();
      }
    }

    function scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    showQuestion(currentIndex);

    // Countdown with localStorage
    const QUIZ_TIME_LIMIT = {{ $quiz->time_limit }} * 60;
    const STORAGE_KEY = 'quizStartTime_{{ $quiz->id }}';
    let timeInSeconds;

    const storedStartTime = localStorage.getItem(STORAGE_KEY);

    if (storedStartTime) {
      const elapsed = Math.floor((Date.now() - parseInt(storedStartTime)) / 1000);
      timeInSeconds = Math.max(QUIZ_TIME_LIMIT - elapsed, 0);
    } else {
      localStorage.setItem(STORAGE_KEY, Date.now());
      timeInSeconds = QUIZ_TIME_LIMIT;
    }

    const timerDisplay = document.getElementById('timer');
    const quizForm = document.getElementById('studentQuizForm');

    const countdown = setInterval(() => {
      const minutes = Math.floor(timeInSeconds / 60);
      const seconds = timeInSeconds % 60;

      timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

      if (timeInSeconds <= 0) {
        clearInterval(countdown);
        alert("Time's up! Your quiz will now be submitted.");
        localStorage.removeItem(STORAGE_KEY);
        quizForm.submit();
      }

      timeInSeconds--;
    }, 1000);

    // Clear the timer if submitted manually
    quizForm.addEventListener('submit', () => {
      localStorage.removeItem(STORAGE_KEY);
    });
  </script>

</body>
</html>
