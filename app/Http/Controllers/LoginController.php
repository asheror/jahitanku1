<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{   
    public function create()
    {
        return view('auth.login'); // Ensure this path matches your login file
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Regenerate the session to prevent session fixation
            $request->session()->regenerate();

            // Redirect based on the user role
            return $this->redirectUser(Auth::user());
        }

        // If authentication fails, throw a validation exception
        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }

    protected function redirectUser($user)
    {
        // Check user role and redirect accordingly
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('Home.index'); // Default redirect for regular users
    }

    public function destroy(Request $request)
    {
        // Log the user out
        Auth::logout();

        // Invalidate the session and regenerate the CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to home
        return redirect('/home');
    }
}
