<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Confession;
use App\Models\Chat;

/**
 * Controller that handles conversation (chat) interactions for confessions.
 *
 * Responsibilities:
 *  - Allow guests to view and reply to a specific confession using a public token
 *  - Allow the confession owner to view the conversation and reply
 *  - Ensure proper ordering, validation and basic authorization
 *
 * Views:
 *  - Guest-facing: `public.chatanon`
 *  - Owner-facing: `chat`
 *
 * Notes:
 *  - `Confession` uses `guest_token` for public/anonymous access. Routes that
 *    expose guest access should name the parameter `{token}` to match methods.
 *  - `Chat` model fields used here:
 *      - `sender_type`: 'guest' | 'user' (indicates origin)
 *      - `is_read`: boolean (tracking read/unread state)
 */
class ChatController extends Controller
{
    /**
     * Show a guest-accessible conversation by token.
     *
     * Route example: GET `/guest/{token}`
     * This method loads the confession and its chats (ordered oldest → newest)
     * and renders the public chat view.
     *
     * @param string $token Public guest token sent in the link
     * @return \Illuminate\View\View
     */
    // Sesuaikan nama parameter dengan {token} di web.php
    public function guestAccess($token)
    {
        // Cari confession berdasarkan token dan muat seluruh chat terurut.
        $confession = Confession::where('guest_token', $token)
                        ->with(['chats' => function($query) {
                            // Pastikan percakapan ditampilkan dari awal (asc).
                            $query->orderBy('created_at', 'asc');
                        }])
                        ->firstOrFail();

        // Tampilan publik yang menampilkan confessions + chats.
        return view('public.chatanon', compact('confession'));
    }

    /**
     * Store a guest's reply to a confession.
     *
     * Validates the incoming message, finds the confession by guest token and
     * appends a new Chat record with `sender_type = 'guest'` and `is_read = false`.
     *
     * @param \Illuminate\Http\Request $request
     * @param string $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function guestReply(Request $request, $token)
    {
        // Batasi panjang pesan dan pastikan ada teks.
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $confession = Confession::where('guest_token', $token)->firstOrFail();

        // Buat entri Chat baru. `is_read = false` karena pemilik belum melihatnya.
        Chat::create([
            'confession_id' => $confession->id,
            'sender_type'   => 'guest', 
            'message'       => $request->message,
            'is_read'       => false,
        ]);

        // Redirect kembali ke halaman obrolan publik.
        return redirect()->back();
    }

    /**
     * Show a conversation to the confession owner.
     *
     * The owner can only access their own confessions; otherwise a 403 is returned.
     * Conversations are ordered oldest → newest for natural reading order.
     *
     * @param int $id Confession ID
     * @return \Illuminate\View\View
     */
    // 1. User Membuka Chat Room
    public function show($id)
    {
        // Cari confession berdasarkan ID dan muat chat yang terkait terurut.
        $confession = \App\Models\Confession::with(['chats' => function($query) {
                            $query->orderBy('created_at', 'asc');
                        }])->findOrFail($id);

        // Validasi: Pastikan user yang membuka adalah pemilik confession.
        if ($confession->user_id != Auth::id()) {
            // Jika tidak, hentikan dengan 403 (Unauthorized).
            abort(403, 'Unauthorized action.');
        }

        // Tandai sebagai terbaca ketika pemilik melihat obrolan
        if ($confession->is_read == 0) {
            $confession->update(['is_read' => true]);
        }

        return view('chat', compact('confession'));
    }

    /**
     * Store an owner's reply to the conversation.
     *
     * Validates message input, ensures the authenticated user owns the confession
     * and appends a Chat record with `sender_type = 'user'`. The owner's replies
     * mark the message readable (is_read = true) by default.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id Confession ID
     * @return \Illuminate\Http\RedirectResponse
     */
    // 2. User Mengirim Balasan
    public function store(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $confession = \App\Models\Confession::findOrFail($id);

        // Validasi Pemilik: hanya pemilik confession yang boleh membalas di ruangan ini.
        if ($confession->user_id != Auth::id()) {
            abort(403);
        }

        // Simpan Balasan (sender_type = 'user').
        \App\Models\Chat::create([
            'confession_id' => $confession->id,
            'sender_type'   => 'user', // Menandakan ini balasan user
            'message'       => $request->message,
            'is_read'       => true,  // Owner's own reply considered read
        ]);

        return redirect()->back();
    }
    
}