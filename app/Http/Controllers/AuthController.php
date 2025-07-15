<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Teachers;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    //  public function login(Request $request)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     // Find the user by username
    //     $user = Students::where('username', $request->username)->first();

    //     // Check if the user exists and the password matches
    //     if ($user && $user->password == $request->password) {
    //         // Save the user data in the session
    //         Session::put('user', $user->id);
            
    //         // Redirect to the student home page
    //         return redirect('/student-subject');
    //     }

    //     // If login fails, redirect back to the login page with error messages
    //     return redirect('/')->with('error', 'Invalid username or password');
    // }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required',
    //         'password' => 'required',
    //     ]);

    //     $student = Students::where('username', $request->username)->first();

    //     if ($student && $student->password === $request->password) {
    //         session(['user' => $student->id]); // Set session
    //         return redirect('/student-subject');
    //     }

    //     return redirect('/')->with('error', 'Invalid credentials.');
    // }

public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    $student = Students::where('username', $request->username)->first();
    if ($student && $student->password === $request->password) {
        session(['user' => $student->id, 'role' => 'student']);
        return redirect('/student-subject');
    }

    $teacher = Teachers::where('username', $request->username)->first();
    if ($teacher && $teacher->password === $request->password) {
        session(['user' => $teacher->id, 'role' => 'teacher']);
        return redirect('/teacher-subject');
    }

    return redirect('/')->with('error', 'Invalid credentials.');
}


public function adminLogin(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Hardcoded admin credentials
    if ($request->username === 'admin' && $request->password === 'admin123') {
        session(['user' => 'admin', 'role' => 'admin']);
        return redirect('/admin-student'); // Change to your actual admin route
    }

    return redirect('/admin-login')->with('error', 'Invalid admin credentials.');
}

   public function logout(Request $request)
    {
        // Store role before flushing session
        $role = session('role');

        // Clear all session data
        session()->flush();

        // Redirect based on role
        if ($role === 'admin') {
            return redirect('/admin-login')->with('success', 'Logged out successfully.');
        } elseif ($role === 'teacher') {
            return redirect('/')->with('success', 'Logged out successfully.');
        } elseif ($role === 'student') {
            return redirect('/')->with('success', 'Logged out successfully.');
        }

        // Default fallback
        return redirect('/')->with('success', 'Logged out successfully.');
    }

}