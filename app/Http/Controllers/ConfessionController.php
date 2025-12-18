<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Confession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Controller responsible for creating and managing confessions.
 *
 * Responsibilities:
 *  - Show the public confession form for a specific user
 *  - Persist confessions submitted by guests
 *  - Provide an inbox for users (authenticated) to see received confessions
 *  - Show a single confession and mark it as read when the owner views it
 *
 * Notes:
 *  - Public confessions use a `guest_token` so guests can later access and
 *    continue the conversation without authentication.
 *  - Consider adding notifications or events when a new confession is created
 *    so the recipient can be notified (email, in-app notification, etc.).
 */
class ConfessionController extends Controller
{
    /**
     * Show the form that lets a guest write a confession for a given user.
     *
     * Route example: GET `/u/{username}`
     *
     * @param string $username The target user's username
     * @return \Illuminate\View\View
     */
    //Menampilkan halaman formulir pesan untuk user tertentu.
    // URL: /u/{username}
    public function create($username)
    {
        // Cari user berdasarkan username, jika tidak ada tampilkan 404
        $user = User::where('username', $username)->firstOrFail();

        return view('public.confess', compact('user'));
    }

    /**
     * Persist a new confession to the database.
     *
     * Validates message content and that the target username exists. Generates a
     * secure guest token (used to access the chat as a guest) and stores the
     * sender's IP address for safety/audit purposes.
     *
     * Route example: POST `/confess`
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    // Menyimpan pesan ke database.
    // URL: /confess (POST)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'message' => 'required|string|max:5000',
            'username_target' => 'required|exists:users,username', // Pastikan penerima valid
        ]);

        // 2. Ambil User Penerima
        $recipient = User::where('username', $request->username_target)->first();

        // 3. Generate Token Unik untuk Guest (Pengirim)
        // Token ini nanti dipakai guest untuk masuk kembali ke chat room
        $guestToken = Str::random(64);

        // 4. Simpan ke Database
        $confession = Confession::create([
            'user_id'     => $recipient->id,
            'message'     => $request->message,
            'guest_token' => $guestToken,
            'ip_address'  => $request->ip(), // Fitur safety
        ]);

        // NOTE: You may want to dispatch an event here to notify the recipient.
        // event(new \App\Events\ConfessionCreated($confession));

        // 5. Redirect Guest langsung ke Chat Room mereka
        // Guest akan otomatis melihat pesan yang baru mereka kirim di room tersebut
        return redirect()->route('chat.guest', ['token' => $guestToken]);
    }

    /**
     * Display the inbox for the authenticated user (list of confessions).
     *
     * Loads related chats to facilitate unread counts and sorts by newest first.
     *
     * @return \Illuminate\View\View
     */
    //Menampilkan Inbox User (Login Required)
    public function index()
    {
        // Ambil semua pesan milik user yang sedang login
        // Urutkan dari yang terbaru (latest)
        $confessions = Confession::where('user_id', Auth::id())
                        ->with('chats') // Load relasi chat untuk menghitung unread
                        ->latest()
                        ->get();

        // Return ke view inbox.blade.php
        return view('dashboard.inbox', compact('confessions'));
    }

    /**
     * Show a single confession to its owner and mark it as read.
     *
     * Security: the authenticated user must be the owner of the confession, or
     * a 403 will be returned. When first viewed, `is_read` is set to true.
     *
     * @param int $id Confession ID
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // 1. Cari pesan
        $confession = Confession::findOrFail($id);

        // 2. Security Check
        if ($confession->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // 3. Tandai pesan sebagai "Sudah Dibaca" jika sebelumnya belum
        if ($confession->is_read == 0) {
            $confession->update(['is_read' => true]);
        }
        // ----------------------------

        return view('dashboard.chat', compact('confession'));
    }
}