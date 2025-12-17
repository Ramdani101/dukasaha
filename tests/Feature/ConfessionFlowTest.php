<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Confession;
use App\Models\Chat;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class ConfessionFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup: Matikan CSRF middleware agar test form lebih mudah.
     * (Opsional, tapi membantu menghindari error 419 di test)
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function guest_can_send_anonymous_confession()
    {
        // 1. Siapkan User Penerima
        $user = User::factory()->create(['username' => 'selebgram']);

        // 2. Guest mengirim pesan (POST ke ConfessionController@store)
        // Perhatikan: Controller kamu butuh 'username_target'
        $response = $this->post(route('confess.store'), [
            'username_target' => $user->username, //
            'message' => 'Halo, ini pesan rahasia pertamaku!',
            // 'g-recaptcha-response' => 'dummy-token' // Jika logic bypass di AuthController diterapkan disini juga
        ]);

        // 3. Cek Database Confessions
        $this->assertDatabaseHas('confessions', [
            'user_id' => $user->id,
            'message' => 'Halo, ini pesan rahasia pertamaku!',
        ]);

        // 4. Pastikan Redirect ke Halaman Chat Guest
        // Controller kamu me-redirect ke route 'chat.guest'
        $response->assertRedirect(); 
        
        // Cek apakah ada token yang digenerate
        $confession = Confession::where('user_id', $user->id)->first();
        $this->assertNotNull($confession->guest_token);
    }

    /** @test */
    public function guest_can_reply_in_chat_room()
    {
        // 1. Setup: Buat User dan Confession yang sudah ada
        $user = User::factory()->create();
        $confession = Confession::create([
            'user_id' => $user->id,
            'message' => 'Awal percakapan',
            'guest_token' => Str::random(64),
            'ip_address' => '127.0.0.1'
        ]);

        // 2. Guest membalas chat (ChatController@guestReply)
        // Asumsi route kamu: POST /chat/{token}/reply
        // Sesuaikan URL ini dengan routes/web.php kamu!
        $response = $this->post("/c/{$confession->guest_token}/reply", [
            'message' => 'Ini balasan dari Guest',
        ]);

        // 3. Cek Database Chats
        $this->assertDatabaseHas('chats', [
            'confession_id' => $confession->id,
            'sender_type' => 'guest', //
            'message' => 'Ini balasan dari Guest',
        ]);

        $response->assertRedirect(); // Controller me-return back()
    }

    /** @test */
    public function logged_in_user_can_reply_to_confession()
    {
        // Tambahkan baris ini biar error merahnya hilang
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        $confession = Confession::create([
            'user_id' => $user->id,
            'message' => 'Pesan masuk',
            'guest_token' => Str::random(64),
        ]);

        // Sekarang actingAs tidak akan error lagi
        $this->actingAs($user);

        // ... kode selanjutnya ...
    }

    /** @test */
    public function user_cannot_read_others_confession()
    {
        // 1. Setup: Dua User berbeda
        /** @var \App\Models\User $userA */
        $userA = User::factory()->create();
        
        /** @var \App\Models\User $userB */
        $userB = User::factory()->create();

        // 2. Pesan ini milik User A
        $confession = Confession::create([
            'user_id' => $userA->id,
            'message' => 'Rahasia User A',
            'guest_token' => Str::random(64),
        ]);

        // 3. Login sebagai User B (Orang lain)
        $this->actingAs($userB);

        // 4. Coba akses halaman chat User A (ChatController@show)
        // Asumsi route kamu: GET /dashboard/chat/{id}
        $response = $this->get("/dashboard/chat/{$confession->id}");

        // 5. Harusnya Ditolak (403 Forbidden)
        // Karena di Controller ada: if ($confession->user_id != Auth::id()) abort(403);
        $response->assertStatus(403); //
    }
}
