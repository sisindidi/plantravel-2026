<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login secara normal (jika password benar)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // JALUR BEBAS (Bypass): Jika gagal, cari user berdasarkan email saja
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if ($user) {
            // Login paksa tanpa peduli passwordnya apa
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // Jika email belum ada di database, kita BUATKAN akun baru secara otomatis!
        $newUser = \App\Models\User::create([
            'name' => explode('@', $credentials['email'])[0], // Pakai nama dari email
            'email' => $credentials['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($credentials['password']),
        ]);

        Auth::login($newUser);
        $request->session()->regenerate();
        return redirect()->intended('/');

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
