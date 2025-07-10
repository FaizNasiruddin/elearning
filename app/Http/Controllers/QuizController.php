<?php

namespace App\Http\Controllers;
use App\Models\Quizzes;
use App\Models\Questions;
use App\Models\Subjects;
use App\Models\Students;
use App\Models\StudentSubject;
use App\Models\StudentQuizMark;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    
    public function showAdminQuiz($subject_id)
    {
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }
        return view('admin-quiz', compact('subject_id'));
    }

    public function createQuiz(Request $request)
{

     if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }

   $validated = $request->validate([
    'quizTitle' => 'required|string|max:255',
    'subject_id' => 'required|exists:subjects,id',
    'start_date' => 'required|date_format:Y-m-d',
    'start_time' => 'required|date_format:H:i',
    'end_date'   => 'required|date_format:Y-m-d',
    'end_time'   => 'required|date_format:H:i',
    'time_limit' => 'required|integer|min:1',
    'question' => 'required|array',
    'question.*.text' => 'required|string',
    'question.*.options' => 'required|array|size:4',
    'question.*.correct_option' => 'required|in:A,B,C,D',
]);

$startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['start_date'] . ' ' . $validated['start_time']);
$endDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $validated['end_date'] . ' ' . $validated['end_time']);
    // Create the quiz
    $quiz = Quizzes::create([
        'title'       => $validated['quizTitle'],
        'subject_id'  => $validated['subject_id'],
        'start_time'  => $startDateTime,
        'end_time'    => $endDateTime,
        'time_limit'  => $validated['time_limit'],
    ]);

    // Save questions
    foreach ($validated['question'] as $q) {
        Questions::create([
            'quiz_id'        => $quiz->id,
            'question_text'  => $q['text'],
            'option_a'       => $q['options'][0],
            'option_b'       => $q['options'][1],
            'option_c'       => $q['options'][2],
            'option_d'       => $q['options'][3],
            'correct_answer' => $q['correct_option'],
        ]);
    }

    return redirect()->back()->with('success', 'Quiz created successfully!');
}


    public function deleteQuiz(Request $request)
    {
        $quiz = Quizzes::findOrFail($request->quiz_id);
        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz deleted successfully.');
    }

    public function editQuiz($quiz_id)
    {
        if (!session()->has('user') || !in_array(session('role'), ['admin', 'teacher'])) {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }
        $quiz = Quizzes::findOrFail($quiz_id);
        return view('admin-quiz-edit', compact('quiz'));
    }

    public function updateQuiz(Request $request, $quiz_id)
    {
        // Validate
        $validated = $request->validate([
            'quizTitle' => 'required|string|max:255',
            'question' => 'required|array',
            'question.*.text' => 'required|string',
            'question.*.options' => 'required|array|size:4',
            'question.*.correct_option' => 'required|in:A,B,C,D',
        ]);

        // Update quiz title
        $quiz = Quizzes::findOrFail($quiz_id);
        $quiz->title = $validated['quizTitle'];
        $quiz->save();

        foreach ($request->question as $q) {
            if (isset($q['id'])) {
                // Update existing question
                $question = Questions::find($q['id']);
                if ($question && $question->quiz_id == $quiz_id) {
                    $question->question_text = $q['text'];
                    $question->option_a = $q['options'][0];
                    $question->option_b = $q['options'][1];
                    $question->option_c = $q['options'][2];
                    $question->option_d = $q['options'][3];
                    $question->correct_answer = $q['correct_option'];
                    $question->save();
                }
            } else {
                // Add new question
                Questions::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $q['text'],
                    'option_a' => $q['options'][0],
                    'option_b' => $q['options'][1],
                    'option_c' => $q['options'][2],
                    'option_d' => $q['options'][3],
                    'correct_answer' => $q['correct_option'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Quiz updated successfully!');
    }


    public function showStudentQuiz ($quiz_id){
        $quiz = Quizzes::with('questions')->findOrFail($quiz_id);
            return view('student-quiz', [
            'quiz' => $quiz,
            'questions' => $quiz->questions,
        ]);
    }

    public function submitQuiz(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
        ]);

        $quizId = $validated['quiz_id'];
        $answers = $validated['answers'];

        // Get student ID from session
        $studentId = Session::get('user');

        if (!$studentId) {
            return redirect()->back()->withErrors(['error' => 'Student not logged in.']);
        }

        // Get quiz questions
        $questions = Questions::where('quiz_id', $quizId)->get();
        $totalQuestions = $questions->count();
        $score = 0;

        foreach ($questions as $question) {
            if (
                isset($answers[$question->id]) &&
                $answers[$question->id] === $question->correct_answer
            ) {
                $score++;
            }
        }

        // Save quiz result
        StudentQuizMark::updateOrCreate(
            [
                'student_id' => $studentId,
                'quiz_id' => $quizId,
            ],
            [
                'score' => $score,
                'total_questions' => $totalQuestions,
            ]
        );

        // Flash success message
        Session::flash('success', "Quiz submitted! You scored $score out of $totalQuestions.");

        // Redirect to student dashboard or result page
    }

    public function showStudentQuizmark($quiz_id, $subject_id)
    {
        if (!session()->has('user') || !in_array(session('role'), ['admin', 'teacher'])) {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }
        // Get the quiz
        $quiz = Quizzes::findOrFail($quiz_id);

        // Get the subject
        $subject = Subjects::findOrFail($subject_id);

        // Get student IDs linked to the subject
        $studentIds = StudentSubject::where('subject_id', $subject_id)->pluck('student_id');

        // Get the students
        $students = Students::whereIn('id', $studentIds)->get();

        // Get quiz marks for this quiz
        $quizMarksRaw = StudentQuizMark::where('quiz_id', $quiz_id)->get();

        // Group marks by student ID for easy lookup
        $quizMarks = $quizMarksRaw->keyBy('student_id');

        // Return view with all needed data
        return view('admin-student-quizmark', compact('quiz', 'subject', 'students', 'quizMarks'));
    }
}
