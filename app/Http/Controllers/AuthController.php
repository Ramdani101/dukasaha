<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use App\Models\User;


class AuthController extends Controller
{
    // --- FITUR REGISTER ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'username' => 'required|string|max:20|unique:users', // Username tidak boleh sama
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // Harus ada input password_confirmation di view
        ]);

        // 2. Simpan ke Database
        User::create([
            'name' => $request->username,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password di-enkripsi
        ]);

        // 3. Redirect ke Login
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // --- FITUR LOGIN ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required' // Wajib diisi
        ], [
            'g-recaptcha-response.required' => 'Silakan centang "I am not a robot".'
        ]);

        // 2. Verifikasi ke Google Server
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        // Jika Google bilang Gagal
        if (!$response->json()['success']) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => 'Verifikasi SPAM gagal, silakan coba lagi.',
            ]);
        }

        // 3. Lanjutkan Proses Login Biasa
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- FITUR LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}