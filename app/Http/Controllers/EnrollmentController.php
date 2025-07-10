<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentSubject;
use App\Models\Students;
use App\Models\Subjects;


class EnrollmentController extends Controller
{
    public function enrollStudent(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Get student and subject models
        $student = Students::find($validated['student_id']);
        $subject = Subjects::find($validated['subject_id']);

        // Check if the student is already enrolled in this subject
        if ($student->subjects()->where('subject_id', $subject->id)->exists()) {
        }

        // Enroll the student in the subject by inserting a record in the pivot table
        $student->subjects()->attach($subject->id);

        return redirect()->to("/admin-subject-particular/{$subject->id}")
                 ->with('success', 'Student enrolled successfully!');
    }

    public function deleteEnrollment(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Get student and subject models
        $student = Students::find($validated['student_id']);
        $subject = Subjects::find($validated['subject_id']);

        // Check if the student is enrolled in the subject
        if (!$student->subjects()->where('subject_id', $subject->id)->exists()) {
            // If not enrolled, redirect back with an error message
            return redirect()->back()->with('error', 'Student is not enrolled in this subject.');
        }

        // Remove the enrollment (detach the subject from the student)
        $student->subjects()->detach($subject->id);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Student successfully removed from the subject.');
    }

    public function showStudentEnroll($subject_id)
    {
        // Get the subject by ID
        $subject = Subjects::find($subject_id);

        // Optional: handle if not found
        if (!$subject) {
            return redirect()->back()->with('error', 'Subject not found.');
        }

        // Get only students with the same form as the subject
        $students = Students::where('form', $subject->form)->get();

        return view('admin-enroll-student', compact('subject', 'students'));
    }
}
