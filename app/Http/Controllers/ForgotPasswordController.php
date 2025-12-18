<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form where users can request a password reset link.
     *
     * View: `resources/views/auth/forgot-password.blade.php`
     * Route: GET `/forgot-password`
     *
     * @return \Illuminate\View\View
     */
    // 1. Tampilkan Form Input Email
    public function showLinkRequestForm()
    {
        // Menampilkan form untuk memasukkan alamat email agar sistem mengirimkan
        // link untuk reset password jika email terdaftar.
        return view('auth.forgot-password');
    }

    /**
     * Validate the email and send a password reset link.
     *
     * Uses Laravel's Password broker: `Password::sendResetLink()`.
     * It will generate a token (stored in `password_resets`) and dispatch
     * a notification (email) using the user's notification system.
     *
     * On success, returns back with a localized status message; on failure
     * returns a validation error without revealing whether the email exists.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // 2. Proses Kirim Link ke Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Laravel's Password broker will generate the token and send the email.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            // Sukses: beri umpan balik ke pengguna.
            return back()->with('status', 'Link reset password sudah dikirim ke emailmu!');
        }

        // Gagal: tidak perlu menjelaskan detail (keamanan).
        return back()->withErrors(['email' => 'Hmm, kami tidak menemukan email tersebut.']);
    }

    /**
     * Show the password reset form which accepts the token from the email.
     *
     * @param \Illuminate\Http\Request $request
     * @param string|null $token
     * @return \Illuminate\View\View
     */
    // 3. Tampilkan Form Buat Password Baru (Setelah klik link di email)
    public function showResetForm(Request $request, $token = null)
    {
        // Menyertakan token dan email agar form dapat memvalidasi pada submit.
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the user's password.
     *
     * Validates `token`, `email`, and `password` (min 8, confirmed). Then calls
     * `Password::reset()` which verifies the token and performs the reset if valid.
     * The closure receives the found user and the new password; inside we hash
     * the password, set a new remember token, save the user, and fire the
     * `PasswordReset` event so other parts of the app can respond.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // 4. Proses Update Password Baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed', 
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                // Hash password baru dan set remember_token baru untuk keamanan.
                $user->forceFill([
                    'password' => bcrypt($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                // Event broadcast: useful for logging, analytics, or cleanup.
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            // Sukses: redirect ke login dengan pesan status.
            return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login.');
        }

        // Token invalid atau data tidak cocok: kembalikan error generik.
        return back()->withErrors(['email' => 'Token invalid atau email salah.']);
    }
}
