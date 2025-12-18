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

/**
 * Registration, authentication and logout controller.
 *
 * Responsibilities:
 *  - Show registration & login forms
 *  - Handle registration (validation, user creation, event dispatch, auto-login)
 *  - Handle login (validation, optional reCAPTCHA verification, session regeneration)
 *  - Handle logout (invalidate session & regenerate CSRF token)
 *
 * Notes:
 *  - Views:
 *      - `resources/views/auth/register.blade.php`
 *      - `resources/views/auth/login.blade.php`
 *  - The registration flow dispatches `Illuminate\Auth\Events\Registered` so listeners
 *    (e.g., email verification or welcome emails) can react.
 *  - reCAPTCHA verification is skipped when running unit tests to make testing easier.
 *  - Messages are currently in Indonesian; consider moving them to `resources/lang` for i18n.
 */
class AuthController extends Controller
{
    // --- FITUR REGISTER ---

    /**
     * Show registration form view.
     *
     * Route: GET `/register` (typical)
     * View: `auth.register`
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * Steps:
     *  1) Validate incoming data
     *  2) Create the user in the database
     *  3) Fire the `Registered` event
     *  4) Log the user in and redirect (or return 201 for JSON requests)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        // 1. Validasi input pendaftaran menggunakan helper `validator()` di bawah.
        $this->validator($request->all())->validate();

        // 2. Buat user baru (hash password dilakukan di create())
        $user = $this->create($request->all());
        
        // 3. Broadcast Registered event so other listeners can perform post-registration work.
        event(new Registered($user));

        // 4. Login user secara otomatis setelah pendaftaran.
        Auth::login($user); 

        // 5. Redirect: support both browser (redirect) and API (201 JSON) responses.
        if ($request->wantsJson()) {
            return new JsonResponse([], 201);
        }

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Create a validator for an incoming registration request.
     *
     * Extracted to a separate method so it can be reused or overridden if needed.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Validation rules for registration.
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        return Validator::make($data, $rules);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * Password is hashed using `Hash::make()`.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // --- FITUR LOGIN ---

    /**
     * Show login form view.
     *
     * Route: GET `/login`
     * View: `auth.login`
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request.
     *
     * Important points:
     *  - Validates basic credentials (`email`, `password`).
     *  - Requires Google reCAPTCHA (unless running unit tests).
     *  - Verifies reCAPTCHA by posting to Google's API and expects `success` boolean.
     *  - Calls `Auth::attempt()` to authenticate and regenerates the session.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        // 1) Basic validation
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        // For tests, we skip the reCAPTCHA requirement to make automated tests simpler.
        if (!app()->runningUnitTests()) {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules, [
            'g-recaptcha-response.required' => 'Please check "I am not a robot".'
        ]);

        // 2) Verify reCAPTCHA with Google (skipped during unit tests).
        if (!app()->runningUnitTests()) {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => env('RECAPTCHA_SECRET_KEY'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            // If Google reports failure, throw a validation exception so the form displays an error.
            if (!$response->json()['success']) {
                throw ValidationException::withMessages([
                    'g-recaptcha-response' => 'Verifikasi SPAM gagal, silakan coba lagi.',
                ]);
            }
        }

        // 3) Attempt authentication using the provided credentials.
        if (Auth::attempt($request->only('email', 'password'))) {
            // Prevent session fixation by regenerating after login.
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // Authentication failed: return generic error message to avoid leaking info.
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // --- FITUR LOGOUT ---

    /**
     * Log the user out of the application.
     *
     * Steps: logout via Auth, invalidate session, regenerate CSRF token, redirect home.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        // Invalidate the current session and generate a new CSRF token for security.
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}