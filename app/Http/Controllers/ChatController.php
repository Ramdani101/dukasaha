<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Confession;
use App\Models\Chat;

class ChatController extends Controller
{
    // Sesuaikan nama parameter dengan {token} di web.php
    public function guestAccess($token)
    {
        // Cari confession berdasarkan token
        $confession = Confession::where('guest_token', $token)
                        ->with(['chats' => function($query) {
                            $query->orderBy('created_at', 'asc');
                        }])
                        ->firstOrFail();

        return view('public.chatanon', compact('confession'));
    }

    // PENTING: Nama method diubah jadi 'guestReply' sesuai web.php
    public function guestReply(Request $request, $token)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $confession = Confession::where('guest_token', $token)->firstOrFail();

        Chat::create([
            'confession_id' => $confession->id,
            'sender_type'   => 'guest', 
            'message'       => $request->message,
            'is_read'       => false,
        ]);

        return redirect()->back();
    }

    // 1. User Membuka Chat Room
    public function show($id)
    {
        // Cari confession berdasarkan ID
        $confession = \App\Models\Confession::with(['chats' => function($query) {
                            $query->orderBy('created_at', 'asc');
                        }])->findOrFail($id);

        // Validasi: Pastikan yang buka adalah pemilik pesan
        if ($confession->user_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('chat', compact('confession'));
    }

    // 2. User Mengirim Balasan
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $confession = \App\Models\Confession::findOrFail($id);

        // Validasi Pemilik
        if ($confession->user_id != Auth::id()) {
            abort(403);
        }

        // Simpan Balasan (sender_type = 'user')
        \App\Models\Chat::create([
            'confession_id' => $confession->id,
            'sender_type'   => 'user', // Menandakan ini balasan Kamu (User)
            'message'       => $request->message,
            'is_read'       => true,
        ]);

        return redirect()->back();
    }
    
}