<?php

namespace App\Http\Controllers;
use App\Models\Teachers;
use App\Models\Subjects;


use Illuminate\Http\Request;

    class TeacherController extends Controller
    {
       public function addTeacher(Request $request)
{
    if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }

    // Step 1: Validate input (no unique rule)
    $request->validate([
        'fullname' => ['required', 'string', 'regex:/^[^0-9]*$/'],
        'username' => 'required|digits:12',
        'password' => 'required',
    ], [
        'fullname.regex' => 'The Full Name must not contain numbers.',
    ], [
        'fullname' => 'Full Name',
        'username' => 'IC Number',
        'password' => 'Password',
    ]);

    // Step 2: Check if IC number (username) already exists
    $exists = Teachers::where('username', $request->username)->first();
    if ($exists) {
        return redirect()->back()
            ->withErrors(['username' => 'This IC number is already registered.'])
            ->withInput();
    }

    // Step 3: Insert new teacher
    Teachers::create([
        'fullname' => $request->fullname,
        'username' => $request->username,
        'password' => $request->password, // 🔒 hash if needed
    ]);

    return redirect('/admin-teacher')->with('message', 'Teacher registered successfully!');
}


    public function showTeacher(Request $request) {
        // ✅ Block access if not logged in as admin
        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $sort = $request->get('sort', 'latest');

        $query = Teachers::query();

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'asc':
                $query->orderBy('fullname', 'asc');
                break;
            case 'desc':
                $query->orderBy('fullname', 'desc');
                break;
            default: // latest
                $query->orderBy('created_at', 'desc');
                break;
        }

        $teachers = $query->get();

        return view('admin-teacher', compact('teachers'));
    }

    public function deleteTeacher(Request $request){
        $id = $request->input('teacher_id');

        $deleted = Teachers::where('id', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with([
                'success' => 'User deleted successfully.',
            ]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }

    }

    public function editTeacher($teacher_id){

        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $teacher = Teachers::findOrFail($teacher_id);
        return view('/admin-teacher-edit' ,compact('teacher'));
    }

    public function updateTeacher(Request $request)
{
    if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }

    // Step 1: Validate input
    $request->validate([
        'teacher_id' => 'required',
        'teacher_name' => 'required|string|regex:/^[^0-9]*$/',
        'teacher_username' => 'required|digits:12',
        'teacher_password' => 'required',
    ], [
        'teacher_name.regex' => 'The Teacher Name must not contain numbers.',
        'teacher_username.digits' => 'The IC number must be exactly 12 digits.',
    ], [
        'teacher_id' => 'Teacher ID',
        'teacher_name' => 'Teacher Name',
        'teacher_username' => 'IC Number',
        'teacher_password' => 'Password',
    ]);

    // Step 2: Check if the IC number (username) is already used by another teacher
    $exists = Teachers::where('username', $request->teacher_username)
        ->where('id', '!=', $request->teacher_id)
        ->first();

    if ($exists) {
        return redirect()->back()
            ->withErrors(['teacher_username' => 'This IC number is already exist.'])
            ->withInput();
    }

    // Step 3: Update the teacher info
    $teacher = Teachers::find($request->teacher_id);
    if ($teacher) {
        $teacher->update([
            'fullname' => $request->teacher_name,
            'username' => $request->teacher_username,
            'password' => $request->teacher_password, // consider Hash::make here
        ]);

        return redirect('/admin-teacher')->with('message', 'Teacher updated successfully!');
    }

    return redirect()->back()->with('error', 'Teacher not found.');
}

   public function showTeacherAdd(){
             if (!session()->has('user') || session('role') !== 'admin') {
                return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
            }
            return view('admin-teacher-add');
    }

    public function showTeacherSubjects()
    {
        if (!session()->has('user') || session('role') !== 'teacher') {
            return redirect('/')->with('error', 'Access denied. Please login as teacher.');
        }
        
        // Get logged-in teacher ID from session
        $teacherId = session('user');

        // Fetch teacher
        $teacher = Teachers::find($teacherId);

        // Fetch subjects where the teacher_id matches
        $subjects = Subjects::where('teacher_id', $teacherId)->get();

        return view('teacher-subject', compact('subjects', 'teacher'));
    }
    
}
