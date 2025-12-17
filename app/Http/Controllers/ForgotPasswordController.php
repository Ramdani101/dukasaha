<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    // 1. Tampilkan Form Input Email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // 2. Proses Kirim Link ke Email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Laravel otomatis handle token & kirim email bawaan
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', 'Link reset password sudah dikirim ke emailmu!');
        }

        return back()->withErrors(['email' => 'Hmm, kami tidak menemukan email tersebut.']);
    }

    // 3. Tampilkan Form Buat Password Baru (Setelah klik link di email)
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // 4. Proses Update Password Baru
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed', // field konfirmasi harus bernama password_confirmation
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password) // Hash password baru
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Password berhasil diubah! Silakan login.');
        }

        return back()->withErrors(['email' => 'Token invalid atau email salah.']);
    }
}
