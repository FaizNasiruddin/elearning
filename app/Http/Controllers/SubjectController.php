<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use App\Models\Students;
use App\Models\Teachers;
use Illuminate\Http\Request;


class SubjectController extends Controller
{
   public function addSubject(Request $request)
{
    // Check if the user is logged in and has 'admin' role
    if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }

    // Validate the input
    $request->validate([
        'subjectname' => 'required',
        'subjectcolor' => 'required',
        'subjectteacher' => 'required',
        'subjectform' => 'required',
    ]);

    // Create the subject
    Subjects::create([
        'name' => $request->subjectname,
        'color' => $request->subjectcolor,
        'teacher_id' => $request->subjectteacher,
        'form' => $request->subjectform,
    ]);

    return redirect('/admin-subject')->with('message', 'Subject added successfully!');
}

    public function deleteSubject(Request $request){
        $id = $request->input('subjectid');

        $deleted = Subjects::where('id', $id)->delete();

        if ($deleted) {
            return redirect()->back()->with([
                'success' => 'User deleted successfully.',
            ]);
        } else {
            return redirect()->back()->with('error', 'User not found.');
        }

    }

    public function editSubject($subject_id){

        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $subject = Subjects::findOrFail($subject_id);
        $teachers = Teachers::all();
        return view('/admin-subject-edit' ,compact('subject','teachers'));
    }

    public function updateSubject(Request $request){

        $request->validate([
            'subject_id' => 'required',
            'subjectname' => 'required',
            'subjectcolor' => 'required',
            'subjectteacher' => 'required',
        ]);

        $subject = Subjects::find($request->subject_id);
        if ($subject) {
            $subject->update([
                'name' => $request->subjectname,
                'color' => $request->subjectcolor,
                'teacher_id' => $request->subjectteacher,
            ]);

            return redirect('/admin-subject')->with('message', 'Subject updated successfully!');
        }

        return redirect()->back()->with('error', 'Subject not found.');
    }

    public function showSubject(Request $request) {
        // ✅ Block access if not logged in as admin
    if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }
        $sort = $request->input('sort', 'latest');   // Get sorting option (default latest)
        $form = $request->input('form', null);       // Get form filter (null if not set)

        $query = Subjects::query();

        // Apply filtering by form if form is set and not empty
        if ($form) {
            $query->where('form', $form);
        }

        // Apply sorting based on input
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'asc':  // Sort by subject name A-Z
                $query->orderBy('name', 'asc');
                break;
            case 'desc': // Sort by subject name Z-A
                $query->orderBy('name', 'desc');
                break;
            default:     // latest (newest first)
                $query->orderBy('created_at', 'desc');
        }

        $subjects = $query->get();
        $teachers = Teachers::all();

        return view('admin-subject', compact('subjects', 'teachers'));
    }

    public function showParticularSubject($subject_id)
    {
         if (!session()->has('user') || session('role') !== 'admin') {
        return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
    }
        // Load the subject by ID
        $subject = Subjects::findOrFail($subject_id);  // Make sure the namespace is correct

        // Filter students whose form matches the subject's form
        $students = Students::where('form', $subject->form)->get();  // Make sure the namespace is correct

        return view('admin-subject-particular', [
            'subject' => $subject,
            'students' => $students,
        ]);
    }

    
    public function showSubjectAdd(){

        if (!session()->has('user') || session('role') !== 'admin') {
            return redirect('/admin-login')->with('error', 'Access denied. Please login as admin.');
        }

        $teachers = Teachers::all();
        return view('admin-subject-add', compact('teachers'));
    }

    
}
