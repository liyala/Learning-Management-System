<?php
// app/Http/Controllers/AuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user()->role->name);
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Proses autentikasi
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Regenerate session untuk menghindari Session Fixation attack
            $request->session()->regenerate();

            // Redirect berdasarkan role
            return $this->redirectBasedOnRole(Auth::user()->role->name);
        }

        // Jika gagal login
        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    private function redirectBasedOnRole(String $role)
    {
        switch ($role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'guru':
                return redirect()->intended('/teacher/dashboard');
            case 'siswa':
                return redirect()->intended('/student/dashboard');
            default:
                Auth::logout();
                return redirect('/login')->withErrors('Role tidak valid.');
        }
    }
}