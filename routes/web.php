<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ChatbotController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('student-login');
});

Route::get('/admin-login', function () {
    return view('admin-login');
});

Route::get('/admin-subject', [SubjectController::class, 'showSubject']);
Route::get('/admin-student', [StudentController::class, 'showStudent']);
Route::get('/admin-teacher', [TeacherController::class, 'showTeacher']);
Route::get('/admin-subject-particular/{subject_id}', [SubjectController::class, 'showParticularSubject']);
Route::get('/admin-subject-edit/{subject_id}', [SubjectController::class, 'editSubject']);
Route::get('/admin-student-edit/{student_id}', [StudentController::class, 'editStudent']);
Route::get('/admin-teacher-edit/{teacher_id}', [TeacherController::class, 'editTeacher']);
Route::get('/admin-subject-content/{subject_id}', [ContentController::class, 'showSubjectContent']); // or remove this if not needed

Route::get('/view-file/{file_id}', [ContentController::class, 'viewFile'])->name('view.file');
Route::get('/student-subject-content/{subject_id}', [ContentController::class, 'showSubjectContentStudent']);

Route::get('/student-subject', [StudentController::class, 'showStudentSubject']);
Route::get('/admin-student-attendance/{attendance_id}/{subject_id}', [ContentController::class, 'showStudentAttendance']);

Route::get('/admin-quiz/{subject_id}', [QuizController::class, 'showAdminQuiz']);
Route::get('/admin-quiz-edit/{quiz_id}', [QuizController::class, 'editQuiz']);
Route::get('/student-quiz/{quiz_id}', [QuizController::class, 'showStudentQuiz']);
Route::get('/admin-student-add', [StudentController::class, 'showStudentAdd']);
Route::get('/admin-teacher-add', [TeacherController::class, 'showTeacherAdd']);
Route::get('/admin-subject-add', [SubjectController::class, 'showSubjectAdd']);
Route::get('/admin-enroll-student/{subject_id}', [EnrollmentController::class, 'showStudentEnroll']);
Route::get('/student-profile', [StudentController::class, 'showStudentProfile']);
Route::get('/admin-content', [ContentController::class, 'showStudentContent']);
Route::get('/admin-student-quizmark/{quiz_id}/{subject_id}', [QuizController::class, 'showStudentQuizMark']);

Route::get('/teacher-subject', [TeacherController::class, 'showTeacherSubjects']);
Route::get('/teacher-subject-content/{subject_id}', [ContentController::class, 'showTeacherSubjectContent']); // or remove this if not needed
Route::get('/teacher-student-attendance/{attendance_id}/{subject_id}', [ContentController::class, 'showStudentAttendanceTeacher']);
Route::post('/adminLogin', [AuthController::class, 'adminLogin']);
Route::get('/teacher-content', [ContentController::class, 'showteacherContent']);
Route::get('/admin-chatbot', [ChatbotController::class, 'showAdminChatbot']);
Route::get('/test', [AuthController::class, 'test']);


Route::post('/studentLogin', [AuthController::class, 'login']);
Route::post('/registerStudent', [StudentController::class, 'addStudent']);
Route::post('/registerTeacher', [TeacherController::class, 'addTeacher']);
Route::post('/addSubject', [SubjectController::class, 'addSubject']);
Route::post('/deleteSubject', [SubjectController::class, 'deleteSubject']);
Route::post('/deleteStudent', [StudentController::class, 'deleteStudent']);
Route::post('/deleteTeacher', [TeacherController::class, 'deleteTeacher']);
Route::post('/updateSubject', [SubjectController::class, 'updateSubject']);
Route::post('/updateStudent', [StudentController::class, 'updateStudent']);
Route::post('/updateTeacher', [TeacherController::class, 'updateTeacher']);
Route::post('/student-enroll',[EnrollmentController::class, 'enrollStudent']);
Route::post('/deleteEnrolledStudent', [EnrollmentController::class, 'deleteEnrollment']);

Route::post('addAttendance',[ContentController::class,'addAttendance']);
Route::post('tickAttendance',[ContentController::class,'tickAttendance']);
Route::post('/file-upload',[ContentController::class, 'uploadFile']);

Route::post('/createQuiz', [QuizController::class, 'createQuiz']);
Route::post('/deleteQuiz', [QuizController::class, 'deleteQuiz']);
Route::post('/deleteAttendance', [ContentController::class, 'deleteAttendance']);

Route::post('/updateQuiz/{quiz_id}', [QuizController::class, 'updateQuiz']);
Route::post('/submitQuiz', [QuizController::class, 'submitQuiz']);
Route::post('/deleteFile', [ContentController::class, 'deleteFile']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::post('/uploadFileChatbot', [ChatbotController::class, 'uploadFileChatbot']);
Route::delete('/deleteKnowledgeBase/{id}', [ChatbotController::class, 'deleteFileChatbot']);





