<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectFiles;
use App\Models\Attendance;
use App\Models\Subjects;
use App\Models\Students;
use App\Models\AttendanceRecord;
use App\Models\StudentSubject;
use App\Models\StudentQuizMark;
use App\Models\Quizzes;
use Illuminate\Support\Carbon;



class ContentController extends Controller
{

    public function showSubjectContent($subject_id)
    {
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }
        $subject = Subjects::findOrFail($subject_id);

        $files = SubjectFiles::where('subjects_id', $subject_id)->get();
        $attendances = Attendance::where('subject_id', $subject_id)->get();
        $quizzes = Quizzes::where('subject_id', $subject_id)->get();

        return view('admin-subject-content', compact('subject', 'files', 'attendances' ,'quizzes'));
    }

    public function showTeacherSubjectContent($subject_id)
    {
        if (!session()->has('user') || session('role') !== 'teacher') {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }
        $subject = Subjects::findOrFail($subject_id);

        $files = SubjectFiles::where('subjects_id', $subject_id)->get();
        $attendances = Attendance::where('subject_id', $subject_id)->get();
        $quizzes = Quizzes::where('subject_id', $subject_id)->get();

        return view('admin-subject-content', compact('subject', 'files', 'attendances' ,'quizzes'));
    }

    public function uploadFile(Request $request)
    {
        if (!session()->has('user') || session('role') !== 'admin') {
           return redirect('/admin-login')->with('error', 'Access denied. Please login.');
        }
        // Validate file and ensure 'id' (subject ID) exists in subjects table
        $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
            'id' => 'required|exists:subjects,id',
        ]);

        $file = $request->file('file');

        SubjectFiles::create([
            'subjects_id' => $request->input('id'),  // get subject ID from hidden input
            'filename' => $file->getClientOriginalName(),
            'filetype' => $file->getClientMimeType(),
            'filesize' => $file->getSize(),
            'filedata' => file_get_contents($file->getRealPath()),
            'uploaded_at' => now(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    public function deleteFile(Request $request){

        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login.');
        }
        $file = SubjectFiles::findOrFail($request->file_id);
        $file->delete();

        return redirect()->back()->with('success', 'File Delete successfully!');
    }

    public function viewFile($id)
    {
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login.');
        }
        $file = SubjectFiles::findOrFail($id);

        return response($file->filedata)
            ->header('Content-Type', $file->filetype)
            ->header('Content-Disposition', 'inline; filename="' . $file->filename . '"');
    }


public function addAttendance(Request $request)
{
    if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login.');
        }
    $validated = $request->validate([
        'subject_id'   => 'required|exists:subjects,id',
        'start_date'   => 'required|date', // Changed from date_format:d/m/Y
        'start_time'   => 'required|date_format:H:i',
        'due_date'     => 'required|date',
        'due_time'     => 'required|date_format:H:i',
    ]);

    // Combine date + time using Carbon (default HTML5 format: Y-m-d)
    $start = Carbon::createFromFormat('Y-m-d H:i', $validated['start_date'] . ' ' . $validated['start_time']);
    $end   = Carbon::createFromFormat('Y-m-d H:i', $validated['due_date'] . ' ' . $validated['due_time']);

    $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6);

    Attendance::create([
        'subject_id'  => $validated['subject_id'],
        'start_time'  => $start,
        'due_time'    => $end,
        'password'    => $password,
    ]);

    return redirect()->back()->with('success', 'Attendance created successfully!');
}



    public function deleteAttendance(Request $request)
    {
        if (!session()->has('user') || session('role') !== 'admin') {
           return redirect('/admin-login')->with('error', 'Access denied. Please login.');
        }
        $attendance = Attendance::findOrFail($request->attendance_id);
        $attendance->delete();

        return redirect()->back()->with('success', 'atttendance deleted successfully.');
    }

    public function showStudentAttendance($attendance_id, $subject_id)
    {
        if (!session()->has('user') || !in_array(session('role'), ['admin', 'teacher'])) {
                return redirect('/')->with('error', 'Access denied. Please login.');
            }
        // Get all student IDs linked to this subject
        $studentIds = StudentSubject::where('subject_id', $subject_id)->pluck('student_id');

        // Get students
        $students = Students::whereIn('id', $studentIds)->get();

        // Get attendance records for this attendance ID
        $attendanceRecords = AttendanceRecord::where('attendance_id', $attendance_id)
                                            ->pluck('student_id')
                                            ->toArray(); // Array of students who are marked present

        // Get attendance and subject models
        $attendance = Attendance::findOrFail($attendance_id);
        $subject = Subjects::findOrFail($subject_id);

        // Pass all data to the view
        return view('admin-student-attendance', compact('students', 'attendanceRecords', 'attendance', 'subject'));
    }

 public function showStudentAttendanceTeacher($attendance_id, $subject_id)
{
    if (!session()->has('user') || session('role') !== 'teacher') {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }
    // Get all student IDs linked to this subject
    $studentIds = StudentSubject::where('subject_id', $subject_id)->pluck('student_id');

    // Get students
    $students = Students::whereIn('id', $studentIds)->get();

    // Get attendance records for this attendance ID
    $attendanceRecords = AttendanceRecord::where('attendance_id', $attendance_id)
                                         ->pluck('student_id')
                                         ->toArray(); // Array of students who are marked present

    // Get attendance and subject models
    $attendance = Attendance::findOrFail($attendance_id);
    $subject = Subjects::findOrFail($subject_id);

    // Pass all data to the view
    return view('teacher-student-attendance', compact('students', 'attendanceRecords', 'attendance', 'subject'));
}


    public function showSubjectContentStudent($subject_id)
    {
        if (!session()->has('user') || session('role') !== 'student') {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }

        $student = session('user');
        $subject = Subjects::findOrFail($subject_id);

        $files = SubjectFiles::where('subjects_id', $subject_id)->get();
        $attendances = Attendance::where('subject_id', $subject_id)->get();
        $quizzes = Quizzes::where('subject_id', $subject_id)->get();

        $userId = session('user');

        // Attendance records
        $attendanceRecords = AttendanceRecord::where('student_id', $userId)
            ->whereIn('attendance_id', $attendances->pluck('id'))
            ->get()
            ->keyBy('attendance_id');

        // Quiz marks for this student and these quizzes
        $quizResults = StudentQuizMark::where('student_id', $userId)
            ->whereIn('quiz_id', $quizzes->pluck('id'))
            ->get()
            ->keyBy('quiz_id');

        return view('student-subject-content', compact(
            'student',
            'subject',
            'files',
            'attendances',
            'quizzes',
            'attendanceRecords',
            'quizResults' // ✅ now available in your Blade view
        ));
    }

    public function tickAttendance(Request $request)
    {
        if (!session()->has('user') || session('role') !== 'student') {
             return redirect('/')->with('error', 'Access denied. Please login.');
        }
        // Validate input
        $request->validate([
            'student_id' => 'required',
            'attendance_id' => 'required',
            'password' => 'required',
        ]);

        // Fetch the attendance
        $attendance = Attendance::find($request->attendance_id);

        // Check if attendance exists and password matches
        if (!$attendance || $attendance->password !== $request->password) {
            return redirect()->back()->with('error', 'Invalid attendance code.');
        }

        // Prevent duplicate marking
        $alreadyMarked = AttendanceRecord::where([
            ['student_id', $request->student_id],
            ['attendance_id', $request->attendance_id]
        ])->exists();

        if ($alreadyMarked) {
            return redirect()->back()->with('info', 'You have already marked attendance.');
        }

        // Mark attendance
        AttendanceRecord::create([
            'student_id' => $request->student_id,
            'attendance_id' => $request->attendance_id,
            'ticked_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Attendance marked successfully!');
    }

    public function showStudentContent()
    {
    // ✅ Block access if not logged in as admin
        if (!session()->has('user') || !in_array(session('role'), ['admin', 'teacher'])) {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }
        $attendances = Attendance::with('subject')->get(); // Load all attendances with their related subject
        $quizzes = Quizzes::with('subject')->get();        // Load all quizzes with their related subject

        return view('admin-content', compact('attendances', 'quizzes'));
    }

    public function showTeacherContent()
    {
    // ✅ Block access if not logged in as admin
        if (!session()->has('user') || !in_array(session('role'), ['admin', 'teacher'])) {
            return redirect('/')->with('error', 'Access denied. Please login.');
        }
        $attendances = Attendance::with('subject')->get(); // Load all attendances with their related subject
        $quizzes = Quizzes::with('subject')->get();        // Load all quizzes with their related subject

        return view('admin-content', compact('attendances', 'quizzes'));
    }

    
}
