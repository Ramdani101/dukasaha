<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\User;

/**
 * Controller for managing the authenticated user's profile.
 *
 * Responsibilities:
 *  - Show profile edit form
 *  - Validate and update profile fields (currently only `username`)
 *  - Safely handle account deletion after verifying the user's password
 *
 * Notes:
 *  - Username rules: alphanumeric+dashes/underscores (alpha_dash), max length 20,
 *    and must be unique across users except for the current user (ignore current id).
 *  - Account deletion uses `current_password` validation rule to confirm the user.
 *  - On delete we logout the user, remove the record, invalidate session and
 *    regenerate CSRF token for security.
 */
class ProfileController extends Controller
{
    /**
     * Show the profile edit view for the current authenticated user.
     *
     * View: `resources/views/profile/edit.blade.php`
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the authenticated user's profile.
     *
     * Validates the `username` with custom messages and uses
     * `Rule::unique()->ignore($user->id)` so the user can keep their current username.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user(); 

        // Validation rules for updating the username.
        $request->validate([
            'username' => [
                'required', 
                'string', 
                'max:20', 
                'alpha_dash', // no spaces, only letters, numbers, dashes and underscores
                Rule::unique('users')->ignore($user->id), // allow own username
            ],
        ], [
            // Localized/custom messages shown to the user when validation fails.
            'username.unique' => 'Yah, username itu sudah dipakai orang lain :(',
            'username.alpha_dash' => 'Username tidak boleh pakai spasi.',
        ]);

        // Persist the updated username.
        $user->update([
            'username' => $request->username
        ]);

        // Redirect back to edit page with a success status message.
        return redirect()->route('profile.edit')->with('status', 'Username berhasil diganti!');
    }

    /**
     * Permanently delete the authenticated user's account.
     *
     * Uses `validateWithBag()` with `current_password` rule to ensure the user
     * actually knows their password before deletion. After deletion, the user
     * is logged out, the session invalidated and CSRF token regenerated.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        // Validate password using a named error bag to separate errors in the view.
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Log out before deleting the account to avoid session issues.
        Auth::logout();

        // Permanently remove the user record.
        $user->delete();

        // Invalidate the session and regenerate CSRF token to be safe.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the homepage after successful deletion.
        return redirect('/');
    }
}