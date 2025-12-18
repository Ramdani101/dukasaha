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
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class);
    }

    /** @test */
    public function test_guest_can_send_anonymous_confession_and_receive_token()
    {
        $user = User::factory()->create(['username' => 'selebgram']);

        // Simulate a guest request from a specific IP
        $response = $this->withServerVariables(['REMOTE_ADDR' => '203.0.113.5'])
                         ->post(route('confess.store'), [
            'username_target' => $user->username,
            'message' => 'Halo, ini pesan rahasia pertamaku!',
        ]);

        $response->assertRedirect();

        $confession = Confession::where('user_id', $user->id)->first();
        $this->assertNotNull($confession, 'Confession record should exist');

        // token generated and has expected length
        $this->assertIsString($confession->guest_token);
        $this->assertEquals(64, strlen($confession->guest_token));

        // IP is stored
        $this->assertEquals('203.0.113.5', $confession->ip_address);

        // message saved
        $this->assertEquals('Halo, ini pesan rahasia pertamaku!', $confession->message);
    }

    /** @test */
    public function test_guest_can_access_guest_chat_room_view()
    {
        $user = User::factory()->create();
        $confession = Confession::create([
            'user_id' => $user->id,
            'message' => 'Test message',
            'guest_token' => Str::random(64),
        ]);

        $response = $this->get(route('chat.guest', ['token' => $confession->guest_token]));

        $response->assertStatus(200);
        $response->assertViewHas('confession', function ($viewConfession) use ($confession) {
            return $viewConfession->id === $confession->id;
        });
    }

    /** @test */
    public function test_guest_can_reply_in_chat_room()
    {
        $user = User::factory()->create();
        $confession = Confession::create([
            'user_id' => $user->id,
            'message' => 'Awal percakapan',
            'guest_token' => Str::random(64),
            'ip_address' => '127.0.0.1'
        ]);

        $response = $this->post(route('chat.guest.reply', ['token' => $confession->guest_token]), [
            'message' => 'Ini balasan dari Guest',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('chats', [
            'confession_id' => $confession->id,
            'sender_type' => 'guest',
            'message' => 'Ini balasan dari Guest',
            'is_read' => false,
        ]);
    }

    /** @test */
    public function test_logged_in_user_can_reply_to_confession_and_owner_reply_is_marked_read()
    {
        // Create the owner and a confession for them
        $user = User::factory()->create();
        $confession = Confession::create([
            'user_id' => $user->id,
            'message' => 'Pesan masuk',
            'guest_token' => Str::random(64),
            'is_read' => false,
        ]);

        /** @var \App\Models\User $user */
        $this->actingAs($user);

        $response = $this->post(route('chat.reply', ['id' => $confession->id]), [
            'message' => 'Balasan dari pemilik',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('chats', [
            'confession_id' => $confession->id,
            'sender_type' => 'user',
            'message' => 'Balasan dari pemilik',
            'is_read' => true,
        ]);

        // The owner's view marks confession as read
        $this->get(route('chat.show', ['id' => $confession->id]));
        $this->assertDatabaseHas('confessions', [
            'id' => $confession->id,
            'is_read' => true,
        ]);
    }

    /** @test */
    public function test_messages_index_lists_confessions_for_authenticated_user()
    {
        $user = User::factory()->create();

        // Create some confessions belonging to this user and others
        Confession::factory()->count(2)->create(['user_id' => $user->id]);
        Confession::factory()->count(1)->create(); // other user

        /** @var \App\Models\User $user */
        $this->actingAs($user);

        $response = $this->get(route('messages.index'));

        $response->assertStatus(200);
        $response->assertViewHas('confessions');

        $confessions = $response->viewData('confessions');
        $this->assertCount(2, $confessions);
    }

    /** @test */
    public function test_user_cannot_read_others_confession()
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $confession = Confession::create([
            'user_id' => $userA->id,
            'message' => 'Rahasia User A',
            'guest_token' => Str::random(64),
        ]);

        /** @var \App\Models\User $userB */
        $this->actingAs($userB);

        $response = $this->get(route('chat.show', ['id' => $confession->id]));

        $response->assertStatus(403);
    }
}
