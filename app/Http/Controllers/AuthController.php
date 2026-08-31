<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login sahifasi
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }


    /**
     * Login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'director') {

                return redirect()
                    ->route('dashboard')
                    ->with(
                        'success',
                        'Direktor sifatida tizimga muvaffaqiyatli kirdingiz.'
                    );
            }

            if ($user->role === 'deputy') {

                return redirect()
                    ->route('dashboard')
                    ->with(
                        'success',
                        'Direktor o‘rinbosari sifatida tizimga muvaffaqiyatli kirdingiz.'
                    );
            }

            if ($user->role === 'teacher') {

                return redirect()
                    ->route('dashboard')
                    ->with(
                        'success',
                        'O‘qituvchi sifatida tizimga muvaffaqiyatli kirdingiz.'
                    );
            }

            Auth::logout();

            return redirect()
                ->route('login')
                ->withErrors([
                    'email' => 'Foydalanuvchi roli aniqlanmadi.',
                ]);
        }

        return back()
            ->withErrors([
                'email' => 'Email yoki parol noto‘g‘ri.',
            ])
            ->withInput(
                $request->only('email')
            );
    }


    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Tizimdan muvaffaqiyatli chiqdingiz.'
            );
    }
}