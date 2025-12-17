<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); // Kita beri tahu kode bahwa ini adalah Model User

        $request->validate([
            'username' => [
                'required', 
                'string', 
                'max:20', 
                'alpha_dash', 
                Rule::unique('users')->ignore($user->id),
            ],
        ], [
            'username.unique' => 'Yah, username itu sudah dipakai orang lain :(',
            'username.alpha_dash' => 'Username tidak boleh pakai spasi.',
        ]);

        // CARA BARU: Lebih Rapi & Aman (Otomatis save)
        $user->update([
            'username' => $request->username
        ]);

        return redirect()->route('profile.edit')->with('status', 'Username berhasil diganti!');
    }

    public function destroy(Request $request)
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}