<?php

namespace App\Http\Controllers;
use App\Models\Students;
use App\Models\AttendanceRecord;
use App\Models\Attendance;
use App\Models\StudentQuizMark;
use App\Models\Quizzes;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function addStudent(Request $request)
{
    // Step 1: Validate input
    $request->validate([
        'username' => 'required|digits:12',
        'password' => 'required',
        'fullname' => ['required', 'string', 'regex:/^[^0-9]*$/'],
        'form' => 'required',
    ], [
        'fullname.regex' => 'The full name must not contain numbers.',
    ], [
        'username' => 'IC Number',
        'fullname' => 'Full Name',
        'password' => 'Password',
        'form' => 'Form',
    ]);

    // Step 2: Check if IC number is already used
    $exists = Students::where('username', $request->username)->first();
    if ($exists) {
        return redirect()->back()
            ->withErrors(['username' => 'This IC number is already registered.'])
            ->withInput();
    }

    // Step 3: Save new student
    Students::create([
        'username' => $request->username,
        'password' => $request->password, // 🔒 consider bcrypt() or Hash::make()
        'fullname' => $request->fullname,
        'form' => $request->form,
    ]);

    return redirect('/admin-student')->with('message', 'Student registered successfully!');
}

    public function deleteStudent(Request $request){
        $id = $request->input('studentid');

        $deleted = Students::where('id', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with([
                'success' => 'User deleted successfully.',
            ]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }

    }

    public function showStudent(Request $request)
    {

        // ✅ Block access if not logged in as admin
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $query = Students::query();

        // Filter by form if selected
        if ($request->filled('form')) {
            $query->where('form', $request->form);
        }

        // Sort by selected option
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'asc':
                $query->orderBy('fullname', 'asc');
                break;
            case 'desc':
                $query->orderBy('fullname', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $students = $query->get();

        return view('admin-student', compact('students'));
    }
    
    public function editStudent($student_id){

        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $student = Students::findOrFail($student_id);
        return view('/admin-student-edit' ,compact('student'));
    }

    public function updateStudent(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'fullname' => ['required', 'string', 'regex:/^[^0-9]*$/'],
        'username' => 'required|digits:12',
        'password' => 'required',
        'form' => 'required',
    ], [
        'fullname.regex' => 'The full name must not contain numbers.',
        'username.digits' => 'The IC number must be exactly 12 digits.',
    ], [
        'fullname' => 'Full Name',
        'username' => 'IC Number',
        'password' => 'Password',
        'form' => 'Form',
    ]);

    // Check for duplicate IC number (used by another student)
    $exists = Students::where('username', $request->username)
        ->where('id', '!=', $request->student_id)
        ->first();

    if ($exists) {
        return redirect()->back()
            ->withErrors(['username' => 'This IC number is already exist.'])
            ->withInput();
    }

    $student = Students::find($request->student_id);
    if ($student) {
        $student->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'password' => $request->password, // 🔒 consider using Hash::make()
            'form' => $request->form,
        ]);

        return redirect('/admin-student')->with('message', 'Student updated successfully!');
    }

    return redirect()->back()->with('error', 'Student not found.');
}

    public function showStudentSubject() {

 if (!session()->has('user') || session('role') !== 'student') {
            return redirect('/')->with('error', 'Access denied. Please login first');
        }

        $userId = session('user');
        $student = Students::find($userId);

        // Eager-load teacher for each subject
        $subjects = $student->subjects()->with('teacher')->get();


        return view('student-subject', compact('student', 'subjects'));
    }

    public function showStudentAdd(){
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }
        return view('admin-student-add');
    }
    
    public function showStudentProfile()
{
        
 if (!session()->has('user') || session('role') !== 'student') {
            return redirect('/')->with('error', 'Access denied. Please login first');
        }

    $userId = session('user');
    $student = Students::find($userId);

    // Load all attendance sessions with their subject
    $attendances = Attendance::with('subject')->get();
     $subjects = $student->subjects;

    // Get the student's attendance records
    $attendanceRecords = AttendanceRecord::where('student_id', $userId)->get()
        ->keyBy('attendance_id'); // For fast checking

    // Get quizzes and marks
    $quizMarksRaw = StudentQuizMark::where('student_id', $userId)->get();
    $quizMarks = $quizMarksRaw->keyBy('quiz_id');

    // Load quizzes with subject for display
    $quizzes = Quizzes::with('subject')->get();

    return view('student-profile', compact('student', 'attendances', 'attendanceRecords', 'quizzes', 'quizMarks','subjects'));
}
}
