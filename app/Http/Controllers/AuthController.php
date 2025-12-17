<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Auth\Events\Registered;    
use Illuminate\Http\JsonResponse;         
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // --- FITUR REGISTER ---
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // 1. Validasi
        // Error kamu sebelumnya terjadi disini karena fungsi validator() belum dibuat
        $this->validator($request->all())->validate();

        // 2. Buat User
        $user = $this->create($request->all());
        
        // Kirim event registered (misal untuk verifikasi email)
        event(new Registered($user));

        // 3. LOGIN KAN USER OTOMATIS
        Auth::login($user); 

        // 4. Redirect
        if ($request->wantsJson()) {
            return new JsonResponse([], 201);
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * INI FUNGSI YANG HILANG (Penyebab Error Undefined Method)
     * Fungsi untuk validasi input pendaftaran
     */
    protected function validator(array $data)
    {
        // Aturan Validasi
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'], // Sesuaikan jika ada username
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        // Bypass Captcha saat Testing (Agar Unit Test Passed)
        if (!app()->runningUnitTests()) {
            // Aktifkan baris ini jika kamu memakai Recaptcha di form Register
            // $rules['g-recaptcha-response'] = ['required', 'captcha']; 
        }

        return Validator::make($data, $rules);
    }

    /**
     * INI JUGA FUNGSI YANG HILANG
     * Fungsi untuk memasukkan data user baru ke database
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'], // Pastikan di database ada kolom username
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // --- FITUR LOGIN ---
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // --- 1. Siapkan Aturan Validasi Dasar ---
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        // LOGIKA TAMBAHAN UNTUK BYPASS TESTING
        if (!app()->runningUnitTests()) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules, [
            'g-recaptcha-response.required' => 'Please check "I am not a robot".'
        ]);

        // --- 2. Verifikasi ke Google Server ---
        if (!app()->runningUnitTests()) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (!$response->json()['success']) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Verifikasi SPAM gagal, silakan coba lagi.',
                ]);
            }
        }

        // --- 3. Lanjutkan Proses Login Biasa ---
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