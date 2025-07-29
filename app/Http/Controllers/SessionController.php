<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store()
    {
        // Validate credentials
        $attributes = request()->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Attempt to log in
        if (!Auth::attempt($attributes)) {
            throw ValidationException::withMessages([
                'username' => 'Sorry, those credentials do not match.',
            ]);
        }

        // Regenerate session to prevent session fixation attacks
        request()->session()->regenerate();

        // Redirect to the dashboard
        return redirect('dashboard');
    }

    public function destroy()
    {
        // Log out the user
        Auth::logout();

        // Redirect to the login page
        return redirect('/');
    }
}
