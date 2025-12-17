<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Confession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Penting untuk generate token acak

class ConfessionController extends Controller
{
    /**
     * Menampilkan halaman formulir pesan untuk user tertentu.
     * URL: /u/{username}
     */
    public function create($username)
    {
        // Cari user berdasarkan username, jika tidak ada tampilkan 404
        $user = User::where('username', $username)->firstOrFail();

        return view('public.confess', compact('user'));
    }

    /**
     * Menyimpan pesan ke database.
     * URL: /confess (POST)
     */
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


        // 5. Redirect Guest langsung ke Chat Room mereka
        // Guest akan otomatis melihat pesan yang baru mereka kirim di room tersebut
        return redirect()->route('chat.guest', ['token' => $guestToken]);
    }

    /**
     * Menampilkan Inbox User (Login Required)
     * (Akan kita buat nanti di Fase 2)
     */
    public function index()
    {
        // Ambil semua pesan milik user yang sedang login
        // Urutkan dari yang terbaru (latest)
        $confessions = Confession::where('user_id', Auth::id())
                        ->with('chats') // Load relasi chat untuk menghitung unread (opsional)
                        ->latest()
                        ->get();

        // Return ke view message.blade.php
        return view('dashboard.inbox', compact('confessions'));
    }

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