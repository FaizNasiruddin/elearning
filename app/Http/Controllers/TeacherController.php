<?php

namespace App\Http\Controllers;
use App\Models\Teachers;
use App\Models\Subjects;


use Illuminate\Http\Request;

    class TeacherController extends Controller
    {
        public function addTeacher(Request $request){

            if (!session()->has('user') || session('role') !== 'admin') {
                return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
            }

            $request->validate([
                'fullname' => 'required',
                'username' => 'required',
                'password' => 'required',
            ]);

            Teachers::create([
                'fullname' => $request->fullname,
                'username' => $request->username,
                'password' => $request->password, // Securely hash password
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

    public function updateTeacher(Request $request){

         if (!session()->has('user') || session('role') !== 'admin') {
                return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
            }
        
        $request->validate([
            'teacher_id' => 'required',
            'teacher_name' => 'required',
        ]);

        $teacher = Teachers::find($request->teacher_id);
        if ($teacher) {
            $teacher->update([
                'fullname' => $request->teacher_name,
            ]);

            return redirect('/admin-teacher')->with('message', 'Subject updated successfully!');
        }

        return redirect()->back()->with('error', 'Subject not found.');
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

        // Fetch subjects where the teacher_id matches
        $subjects = Subjects::where('teacher_id', $teacherId)->get();

        return view('teacher-subject', compact('subjects'));
    }
    
}
